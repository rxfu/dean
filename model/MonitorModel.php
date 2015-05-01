<?php

/**
 * 评教监控模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class MonitorModel extends ManagerAdminModel {

	/**
	 * 清空系统设置
	 * @return boolean 成功返回TRUE，否则返回FALSE
	 */
	public function clearSetting() {
		$deleted = $this->db->delete('DELETE FROM t_xt_jxpg');

		return $deleted;
	}

	/**
	 * 设置系统状态
	 * @param  string $year   年度
	 * @param  string $term   学期
	 * @param  string $status 评教状态，开放为1，关闭为0
	 * @return boolean         设置成功返回TRUE，否则返回FALSE
	 */
	public function setup($year, $term, $status) {
		$data['c_nd']   = $year;
		$data['c_xq']   = $term;
		$data['c_flag'] = $status;

		$inserted = $this->db->insertRecord('t_xt_jxpg', $data);

		return $inserted;
	}

	/**
	 * 获取系统设置
	 * @return mixed 成功返回系统设置数据，否则返回FALSE
	 */
	public function getSetting() {
		$sql  = 'SELECT * FROM t_xt_jxpg';
		$data = $this->db->getRow($sql);

		return has($data) ? $data : false;
	}

	public function init($year,$term) {
		//创建课程评教得分总表
 $sql = 'TRUNCATE kctable, kcxhtable, xkxxtable';
 $this->db->delete($sql);
 //kcxhTable 临时表 记录各门课程序号的实评人数
 $sql = 'INSERT INTO kcxhtable SELECT DISTINCT c_kcxh, c_kcbh, COUNT(*) / 10 FROM t_zl_xspf WHERE c_nd = ? AND c_xq = ? GROUP BY c_kcxh';
 $this->db->insert($sql, array($year, $term));
//kctable 临时表 记录某课程序号所有指标下各评分等级的人数
 $sql = 'INSERT INTO kctable SELECT c_kcxh, c_xm, rank_id, COUNT(*) FROM t_zl_xspf WHERE c_nd = ? and c_xq = ? GROUP BY c_kcxh, c_xm, rank_id';
 $this->db->insert($sql, array($year,$term));
//xkxxtable 临时表 记录某课程的选课人数，也即课程的应评人数 
 $sql = 'INSERT INTO xkxxtable SELECT c_kcxh, COUNT(*) FROM t_xk_xkxx WHERE c_nd = ? and c_xq = ? GROUP BY c_kcxh';
 $this->db->insert($sql, array($year,$term));
//detailTable 存入二级指标得分 每个课程序号有10条记录
 $detailTable = $year.$term."Mark"; 
 $sql = "CREATE TABLE $detailTable(
	       c_kcxh VARCHAR(10) NOT NULL,
		   c_kcbh VARCHAR(10) NOT NULL,
		   c_jsgh VARCHAR(6) NOT NULL,
		   c_xm CHAR(2) NOT NULL,
		   s_mark NUMERIC(5,2)
    	)";
 $this->db->exec($sql);
	
 $tablename=$year.$term."t"; 
 $sql = "CREATE TABLE $tablename(
	       c_kcbh VARCHAR(10) NOT NULL,
	       c_kcxh VARCHAR(10) NOT NULL,
		   c_kcxz CHAR(2),
	       c_kcyx VARCHAR(20) NOT NULL,
		   c_skzy VARCHAR(40) NOT NULL,
		   c_jsgh CHAR(10) NOT NULL,
		   c_jsyx CHAR(20),   
		   s_jxtd NUMERIC(5,2),
		   s_jxnr NUMERIC(5,2),	  
		   s_jxff NUMERIC(5,2),
		   s_jxxg NUMERIC(5,2),	  
		   s_zhpf NUMERIC(5,2),
		   s_cprs INTEGER(4),
		   s_sprs INTEGER(4)
    	)";
$rowCount=$this->db->exec($sql);
   if (0 === $rowCount) {
   	return false;
   }

   $sql = "CREATE INDEX c_kcxh ON $tablename(c_kcxh(10))";
   $this->db->exec($sql);

   $sql = 'SELECT c_kcxh, c_kcbh, s_sprs FROM kcxhtable';
   $data = $this->db->search($sql);
   foreach ($data as $row) {   	
	 $kcxh=$row[0];                         //课程序号   
	 $kcxz=substr($row[0],0,2);             //课程性质编号 
	 $sprs=$row[2];                         //实评人数     
	 
	 $nnn=array();                          //nnn[i][j][k]统计第i个一级指标下的第j 个二级指标评分等级为k的学生人数
	 for($i=1;$i<=$yjzb_num;$i++){
        for($j=1;$j<=$ejzb_num[$i];$j++){
		   $ejzb=$ejzb_id[$i][$j];
		   $sql = 'SELECT rank_id, num FROM kctable WHERE c_kcxh = ? AND c_xm = ?';
		   $ranks = $this->db->search($sql, array($kcxh,$ejzb));
		   foreach ($ranks as $rank) {
		   	$nnn[$i][$j][$rank[0]]=$rank[1];
		   }
	    }
	}

	$sql = 'SELECT DISTINCT c_jsgh FROM t_pk_kb WHERE c_kcxh = ? and c_nd = ? and c_xq = ?';
	$jsghRec = $this->db->getRow($sql,array($row[0], $year,$term));
	$jsgh=$jsghRec[0];         //教师工号 
	$kcbh=$row[1];             //课程编号      

	$f=array();                                //存放一级指标得分      
    $f_f=0.0;                                  //该门课程的最终评分
    for($i=1;$i<=$yjzb_num;$i++){
      $f[$i]=0;
      for($j=1;$j<=$ejzb_num[$i];$j++){
	     $ejzb=$ejzb_id[$i][$j];
	     $sum=0;
		 for($k=1;$k<=$rank_num;$k++){
		   $sum=$sum+$zb_rank[$k]*$nnn[$i][$j][$k];
		 }
		 if($sprs>0) $ff=$sum/$sprs;
		 else $ff=0;
		 $mark=$ff;
		 mysql_query("insert into jxpg.$detailtable(c_kcxh,c_kcbh,c_jsgh,c_xm,s_mark) values('$kcxh','$kcbh','$jsgh','$ejzb','$mark')");
		 $f[$i]=$f[$i]+$ejzb_qz[$i][$j]*$ff;
	  }
	  $f_f=$f_f+$yjzb_qz[$i]*$f[$i];
	}
	 $cprs_res=mysql_query("SELECT s_cprs FROM jxpg.xkxxtable where c_kcxh='$all_row[0]'",$db);
	 $cprs_row=mysql_fetch_row($cprs_res);
	 $jsyx_res=mysql_query("select distinct c_mc from jwxt.t_xt_yxbh,jwxt.t_pk_js1 where t_xt_yxbh.c_xb=c_yx and c_jsgh='$jsgh_row[0]'",$db);
	 $jsyx_row=mysql_fetch_row($jsyx_res);
	 $res_skzy=mysql_query("SELECT distinct c_zyh,c_nj,c_mc FROM jwxt.t_xt_yxbh, jwxt.t_xt_yxzy, jwxt.t_pk_kb WHERE c_xb = c_yx AND c_zy = c_zyh and c_kcxh='$all_row[0]' and c_nd='$ND' and c_xq='$XQ' ",$db);
	 $row_skzy=mysql_fetch_row($res_skzy);
	 $res_skmc=mysql_query("select c_mc from jwxt.t_xt_zybh where c_zy='$row_skzy[0]'",$db);
	 $row_skmc=mysql_fetch_row($res_skmc);

	 $JSYX=$jsyx_row[0];         //教师院系
	 $CPRS=$cprs_row[0];         //课程应评人数(即选课人数)
	                          
	 $SKZY=$row_skzy[1]."级".$row_skmc[0];     //授课年级、专业
	 $KCYX=$row_skzy[2];                       //课程开设院系
   	 $sql2="insert into jxpg.$tablename(c_kcbh,c_kcxh,c_kcxz,c_kcyx,c_skzy,c_jsgh,c_jsyx,s_jxtd,s_jxnr,s_jxff,s_jxxg,s_zhpf,s_cprs,s_sprs) values('$KCBH','$KCXH','$KCXZ','$KCYX','$SKZY','$JSGH','$JSYX','$F[1]','$F[2]','$F[3]','$F[4]','$F_F','$CPRS','$all_row[2]')";
	 mysql_query($sql2) or die(mysql_error()."  插入记录失败!");
	 $ALL.next;
   }
   $ALL=mysql_query("select c_kcxh,c_kcbh,s_sprs from jxpg.kcxhtable",$db);
	while($all_row=mysql_fetch_row($ALL))
	{
	 $KCXH=$all_row[0];                         //课程序号   
	 $KCXZ=substr($all_row[0],0,2);             //课程性质编号 
	 $SPRS=$all_row[2];                         //实评人数     
	 
	 $NNN=array();                              //NNN[i][j][k]统计第i个一级指标下的第j 个二级指标评分等级为k的学生人数
	 for($i=1;$i<=$yjzb_num;$i++){
        for($j=1;$j<=$ejzb_num[$i];$j++){
		   $ejzb=$ejzb_id[$i][$j];
		   $res=mysql_query("select rank_id,num from jxpg.kctable where c_kcxh='$KCXH' and c_xm='$ejzb'",$db);
		   while($row=@mysql_fetch_row($res)){ 
	           $NNN[$i][$j][$row[0]]=$row[1];
			   $res.next;
 		   }
	    }
     }
	mysql_free_result($res);

    $jsgh_res=mysql_query("select distinct c_jsgh from jwxt.t_pk_kb where c_kcxh='$all_row[0]' and c_nd='$ND' and c_xq='$XQ' ",$db);
    $jsgh_row=mysql_fetch_row($jsgh_res);
	$JSGH=$jsgh_row[0];         //教师工号 
	$KCBH=$all_row[1];          //课程编号      

	$F=array();                                //存放一级指标得分      
    $F_F=0.0;                                  //该门课程的最终评分
    for($i=1;$i<=$yjzb_num;$i++){
      $F[$i]=0;
      for($j=1;$j<=$ejzb_num[$i];$j++){
	     $ejzb=$ejzb_id[$i][$j];
	     $sum=0;
		 for($k=1;$k<=$rank_num;$k++){
		   $sum=$sum+$zb_rank[$k]*$NNN[$i][$j][$k];
		 }
		 if($SPRS>0) $FF=$sum/$SPRS;
		 else $FF=0;
		 $mark=$FF;
		 mysql_query("insert into jxpg.$detailTable(c_kcxh,c_kcbh,c_jsgh,c_xm,s_mark) values('$KCXH','$KCBH','$JSGH','$ejzb','$mark')");
		 $F[$i]=$F[$i]+$ejzb_qz[$i][$j]*$FF;
	  }
	  $F_F=$F_F+$yjzb_qz[$i]*$F[$i];
	}
	 $cprs_res=mysql_query("SELECT s_cprs FROM jxpg.xkxxtable where c_kcxh='$all_row[0]'",$db);
	 $cprs_row=mysql_fetch_row($cprs_res);
	 $jsyx_res=mysql_query("select distinct c_mc from jwxt.t_xt_yxbh,jwxt.t_pk_js1 where t_xt_yxbh.c_xb=c_yx and c_jsgh='$jsgh_row[0]'",$db);
	 $jsyx_row=mysql_fetch_row($jsyx_res);
	 $res_skzy=mysql_query("SELECT distinct c_zyh,c_nj,c_mc FROM jwxt.t_xt_yxbh, jwxt.t_xt_yxzy, jwxt.t_pk_kb WHERE c_xb = c_yx AND c_zy = c_zyh and c_kcxh='$all_row[0]' and c_nd='$ND' and c_xq='$XQ' ",$db);
	 $row_skzy=mysql_fetch_row($res_skzy);
	 $res_skmc=mysql_query("select c_mc from jwxt.t_xt_zybh where c_zy='$row_skzy[0]'",$db);
	 $row_skmc=mysql_fetch_row($res_skmc);

	 $JSYX=$jsyx_row[0];         //教师院系
	 $CPRS=$cprs_row[0];         //课程应评人数(即选课人数)
	                          
	 $SKZY=$row_skzy[1]."级".$row_skmc[0];     //授课年级、专业
	 $KCYX=$row_skzy[2];                       //课程开设院系
   	 $sql2="insert into jxpg.$tablename(c_kcbh,c_kcxh,c_kcxz,c_kcyx,c_skzy,c_jsgh,c_jsyx,s_jxtd,s_jxnr,s_jxff,s_jxxg,s_zhpf,s_cprs,s_sprs) values('$KCBH','$KCXH','$KCXZ','$KCYX','$SKZY','$JSGH','$JSYX','$F[1]','$F[2]','$F[3]','$F[4]','$F_F','$CPRS','$all_row[2]')";
	 mysql_query($sql2) or die(mysql_error()."  插入记录失败!");
	 $ALL.next;
  }
 mysql_free_result($ALL);
 mysql_close($db); 
	}
}
