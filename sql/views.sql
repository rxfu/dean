课程基本信息：
CREATE OR REPLACE VIEW v_xk_kcxx AS 
 SELECT DISTINCT a.kch, a.kcmc, a.kcywmc, a.xf, a.xs, a.kcjj, b.jc, b.cks, d.mc AS kh, e.bl
   FROM t_jx_kc a
   LEFT JOIN t_jx_kc_xx b ON a.kch = b.kch
   LEFT JOIN t_jx_jxjh c ON a.kch = c.kch
   LEFT JOIN t_zd_khfs d ON c.kh = d.dm
   LEFT JOIN ( SELECT t_jx_cjfs.fs, string_agg((t_jx_cjfs.bl / 10)::text, ':'::text) AS bl
   FROM t_jx_cjfs
  GROUP BY t_jx_cjfs.fs) e ON c.fs = e.fs
  WHERE a.zt = '1'::bpchar
  ORDER BY a.kch;

学生成绩单：
CREATE OR REPLACE VIEW v_xk_xscj AS 
 SELECT a.xh, a.nd, a.xq, a.kch, b.kcmc, b.kcywmc, a.cj, a.xf, a.jd, c.mc AS kcxz, d.mc AS kh, a.kszt
   FROM t_cj_zxscj a
   LEFT JOIN t_jx_kc b ON a.kch = b.kch
   LEFT JOIN t_zd_xz c ON a.kcxz = c.dm
   LEFT JOIN t_zd_khfs d ON a.kh::bpchar = d.dm;

学生已选课程表：
CREATE OR REPLACE VIEW v_xk_xskcb AS 
 SELECT a.xh, a.nd, a.xq, a.kcxh, a.kch, b.kcmc, b.kcywmc, a.xf, g.xm AS jsxm, e.mc AS xqh, f.jxl, f.mc AS jsmc, c.ksz, c.jsz, c.zc, c.ksj, c.jsj, a.kkxy
   FROM t_xk_xkxx a
   LEFT JOIN t_jx_kc b ON a.kch = b.kch
   LEFT JOIN t_pk_kb c ON a.nd = c.nd AND a.xq = c.xq AND a.kcxh = c.kcxh
   LEFT JOIN t_zd_xqh e ON c.xqh = e.dm
   LEFT JOIN t_js_jsxx f ON c.cdbh = f.jsh
   LEFT JOIN t_pk_js g ON a.jsgh = g.jsgh::bpchar;

学生基本信息：
CREATE OR REPLACE VIEW v_xk_xsjbxx AS 
 SELECT a.xh, a.xm, b.mc AS xy, a.zy AS zyh, c.mc AS zy, a.nj, a.zsjj, a.xz, a.byfa
   FROM t_xs_zxs a
   JOIN t_xt_department b ON a.xy = b.dw
   JOIN t_jx_zy c ON a.zy = c.zy;

学生详细信息：
CREATE OR REPLACE VIEW v_xk_xsxx AS 
 SELECT a.xh, a.xm, a.cym, a.xmpy, b.mc AS xb, a.csny, c.mc AS mz, d.mc AS gj, e.mc AS xy, f.mc AS xs, g.mc AS zy, a.zyfs, h.mc AS zy2, i.mc AS fxzy, a.bj, a.xz, j.mc AS xjzt, k.mc AS zylb, a.rxrq, l.mc AS rxfs, a.bxxs, m.mc AS bxlx, a.xxxs, n.mc AS zsjj, o.mc AS syd, a.jg, a.csd, p.mc AS zzmm, a.jrrq, a.tc, a.zxmc, a.jzxm, a.yzbm, a.jtdz, a.lxdh, q.mc AS zjlx, a.sfzh, a.nj, a.sfldm, a.zxwyyz, a.zxwyjb, a.jsjdj, a.bz, a.zp, a.byfa, a.hcdz, a.ksh
   FROM t_xs_zxs a
   LEFT JOIN t_zd_xb b ON a.xbdm = b.dm
   LEFT JOIN t_zd_mz c ON a.mzdm = c.dm
   LEFT JOIN t_zd_gj d ON a.gj = c.dm
   LEFT JOIN t_xt_department e ON a.xy = e.dw
   LEFT JOIN t_zd_xsh f ON a.xsh = f.dm
   LEFT JOIN t_jx_zy g ON a.zy = g.zy
   LEFT JOIN t_jx_zy h ON a.zy2 = h.zy
   LEFT JOIN t_jx_zy i ON a.fxzy = i.zy
   LEFT JOIN t_zd_xjzt j ON a.xjzt = j.dm::bpchar
   LEFT JOIN t_zd_zylb k ON a.zylb = k.dm
   LEFT JOIN t_zd_rxfs l ON a.rxfs = l.dm
   LEFT JOIN t_zd_bxlx m ON a.bxlx = m.dm
   LEFT JOIN t_zd_zsjj n ON a.zsjj = n.dm
   LEFT JOIN t_zd_syszd o ON a.syszd = o.dm::bpchar
   LEFT JOIN t_zd_zzmm p ON a.zzmm = p.dm
   LEFT JOIN t_zd_zjlx q ON a.zjlx = q.dm;

教学计划信息：
CREATE OR REPLACE VIEW v_xk_jxjh AS 
 SELECT a.zy, a.nj, a.zsjj, a.kch, b.kcmc, b.kcywmc, c.mc AS pt, d.mc AS xz, a.xl, a.llxf, a.syxf, a.zxf, a.llxs, a.syxs, a.kxq, e.mc AS kkxy, f.mc AS kh, a.fs, a.lx
   FROM t_jx_jxjh a
   LEFT JOIN t_jx_kc b ON a.kch = b.kch
   LEFT JOIN t_zd_pt c ON a.pt = c.dm
   LEFT JOIN t_zd_xz d ON a.xz = d.dm
   LEFT JOIN t_xt_department e ON a.kxy = e.dw
   LEFT JOIN t_zd_khfs f ON a.kh = f.dm
  ORDER BY a.pt, a.xz, a.kxq;