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
 $sql = 'TRUNCATE kctable';
 $this->db->query($sql);
 $sql = 'TRUNCATE kcxhtable';
 $this->db->query($sql);
 $sql = 'TRUNCATE xkxxtable';
 $this->db->query($sql);
 //kcxhTable 临时表 记录各门课程序号的实评人数
 mysql_query("insert into jxpg.kcxhtable select distinct c_kcxh,c_kcbh,count(*)/10 from jxpg.t_zl_xspf where c_nd='$ND' and c_xq='$XQ' group by c_kcxh");
//kctable 临时表 记录某课程序号所有指标下各评分等级的人数
 mysql_query("insert into jxpg.kctable SELECT c_kcxh,c_xm,rank_id,count(*) FROM jxpg.t_zl_xspf where c_nd = '$ND' and c_xq ='$XQ' GROUP BY c_kcxh ,c_xm, rank_id");
//xkxxtable 临时表 记录某课程的选课人数，也即课程的应评人数 
 mysql_query("insert into jxpg.xkxxtable select c_kcxh,count(*) FROM jwxt.t_xk_xkxx where c_nd='$ND' and c_xq='$XQ' group by c_kcxh ");
//detailTable 存入二级指标得分 每个课程序号有10条记录
 $detailTable=$ND.$XQ."Mark"; 
 $sql1 ="create table jxpg.$detailTable(
       c_kcxh varchar(10) not null,
	   c_kcbh varchar(10) not null,
	   c_jsgh varchar(6) not null,
	   c_xm char(2) not null,
	   s_mark float(5,2)
    )";
 mysql_query($sql1);
	
 $tablename=$ND.$XQ."t"; 
 $sql ="create table jxpg.$tablename(
       c_kcbh varchar(10) not null,
       c_kcxh varchar(10) not null,
	   c_kcxz char(2),
       c_kcyx varchar(20) not null,
	   c_skzy varchar(40) not null,
	   c_jsgh char(10) not null,
	   c_jsyx char(20),   
	   s_jxtd float(5,2),
	   s_jxnr float(5,2),	  
	   s_jxff float(5,2),
	   s_jxxg float(5,2),	  
	   s_zhpf float(5,2),
	   s_cprs int(4),
	   s_sprs int(4)
    )";
   mysql_query($sql) or die("数据表已经存在! 请先删除后再创建!"); 
   mysql_query("create index c_kcxh ON $tablename(c_kcxh(10))");
   include "config.inc.php";
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
