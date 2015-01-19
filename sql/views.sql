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

ALTER TABLE v_xk_kcxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_kcxx
  IS '课程基本信息视图';

学生成绩单：
CREATE OR REPLACE VIEW v_xk_xscj AS 
 SELECT a.xh, a.nd, a.xq, a.kch, b.kcmc, b.kcywmc, a.cj, a.xf, a.jd, c.mc AS kcxz, d.mc AS kh, a.kszt
   FROM t_cj_zxscj a
   LEFT JOIN t_jx_kc b ON a.kch = b.kch
   LEFT JOIN t_zd_xz c ON a.kcxz = c.dm
   LEFT JOIN t_zd_khfs d ON a.kh::bpchar = d.dm;

ALTER TABLE v_xk_xscj
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xscj
  IS '学生成绩单视图';

学生已选课程表：
CREATE OR REPLACE VIEW v_xk_xskcb AS 
 SELECT a.xh, a.nd, a.xq, a.kcxh, a.kch, b.kcmc, b.kcywmc, a.xf, g.xm AS jsxm, e.mc AS xqh, f.jxl, f.mc AS jsmc, c.ksz, c.jsz, c.zc, c.ksj, c.jsj, a.kkxy
   FROM t_xk_xkxx a
   LEFT JOIN t_jx_kc b ON a.kch = b.kch
   LEFT JOIN t_pk_kb c ON a.nd = c.nd AND a.xq = c.xq AND a.kcxh = c.kcxh
   LEFT JOIN t_zd_xqh e ON c.xqh = e.dm
   LEFT JOIN t_js_jsxx f ON c.cdbh = f.jsh
   LEFT JOIN t_pk_js g ON a.jsgh = g.jsgh::bpchar;

ALTER TABLE v_xk_xskcb
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xskcb
  IS '学生已选课程表视图';

学生基本信息：
CREATE OR REPLACE VIEW v_xk_xsjbxx AS 
 SELECT a.xh, a.xm, b.mc AS xy, c.xq AS xqh, a.zy AS zyh, d.mc AS zy, a.nj, a.zsjj, a.xz, a.byfa
   FROM t_xs_zxs a
   JOIN t_xt_department b ON a.xy = b.dw
   LEFT JOIN t_xk_xyxq c ON a.xy = c.xy
   JOIN t_jx_zy d ON a.zy = d.zy;

ALTER TABLE v_xk_xsjbxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xsjbxx
  IS '学生基本信息视图';

学生详细信息：
CREATE OR REPLACE VIEW v_xk_xsxx AS 
 SELECT a.xh, a.xm, a.cym, a.xmpy, b.mc AS xb, a.csny, c.mc AS mz, d.mc AS gj, e.mc AS xy, f.mc AS xs, g.mc AS zy, a.zyfs, h.mc AS zy2, i.mc AS fxzy, a.bj, a.xz, j.mc AS xjzt, k.mc AS zylb, a.rxrq, l.mc AS rxfs, r.mc AS bxxs, m.mc AS bxlx, s.mc AS xxxs, n.mc AS zsjj, o.mc AS syd, a.jg, a.csd, p.mc AS zzmm, a.jrrq, a.tc, a.zxmc, a.jzxm, a.yzbm, a.jtdz, a.lxdh, q.mc AS zjlx, a.sfzh, a.nj, a.sfldm, a.zxwyyz, a.zxwyjb, a.jsjdj, a.bz, a.zp, a.byfa, a.hcdz, a.ksh
   FROM t_xs_zxs a
   LEFT JOIN t_zd_xb b ON a.xbdm = b.dm
   LEFT JOIN t_zd_mz c ON a.mzdm = c.dm
   LEFT JOIN t_zd_gj d ON a.gj = d.dm
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
   LEFT JOIN t_zd_zjlx q ON a.zjlx = q.dm
   LEFT JOIN t_zd_bxxs r ON a.bxxs = r.dm
   LEFT JOIN t_zd_xxxs s ON a.xxxs = s.dm;

ALTER TABLE v_xk_xsxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xsxx
  IS '学生详细信息视图';

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

ALTER TABLE v_xk_jxjh
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_jxjh
  IS '教学计划信息视图';

可选课程信息：
CREATE OR REPLACE VIEW v_xk_kxkcxx AS 
 SELECT a.nd,
    a.xq,
    e.nj,
    e.zsjj,
    e.zy,
    e.pt,
    e.xz,
    e.xl,
    a.kcxh,
    c.kch,
    d.kcmc,
    d.kcywmc,
    f.llxs + f.syxs AS xs,
    f.zxf AS xf,
    a.cdbh,
    a.xqh,
    a.ksz,
    a.jsz,
    a.zc,
    a.ksj,
    a.jsj,
    a.jsgh,
    b.xm AS jsxm,
    a.hb,
    a.rs,
    e.kkxy,
    g.mc AS kh,
    e.bz
   FROM t_pk_kb a
     LEFT JOIN t_pk_js b ON b.jsgh::text = a.jsgh::text
     LEFT JOIN t_pk_jxrw c ON c.kcxh::text = a.kcxh::text AND c.nd::text = a.nd::text AND c.xq::text = a.xq::text AND c.id = 1
     LEFT JOIN t_jx_kc d ON d.kch::text = c.kch::text
     LEFT JOIN t_pk_kczy e ON e.nd::text = a.nd::text AND e.xq::text = a.xq::text AND e.kcxh::text = a.kcxh::text
     LEFT JOIN t_jx_jxjh f ON f.zy::text = e.zy::text AND f.nj::text = e.nj::text AND f.zsjj::text = e.zsjj::text AND f.kch::text = c.kch::text
     LEFT JOIN t_zd_khfs g ON g.dm::text = f.kh::text;

ALTER TABLE v_xk_kxkcxx
  OWNER TO jwxt;
GRANT ALL ON TABLE v_xk_kxkcxx TO jwxt;
GRANT ALL ON TABLE v_xk_kxkcxx TO kongsir;
COMMENT ON VIEW v_xk_kxkcxx
  IS '可选课程信息视图';


教师信息：
CREATE OR REPLACE VIEW v_pk_jsxx AS 
 SELECT a.jsgh, a.xm, b.mc AS xb, a.csrq, c.mc AS gj, d.mc AS zjlx, sfzh, e.mc AS xl, f.mc AS xw, g.mc AS zc, a.zy, a.jj, h.mc AS xy, i.mc AS xs, j.mc AS jys, a.zt
   FROM t_pk_js a
   LEFT JOIN t_zd_xb b ON a.xb = b.dm
   LEFT JOIN t_zd_gj c ON a.gj = c.dm
   LEFT JOIN t_zd_zjlx d ON a.zjlx = d.dm
   LEFT JOIN t_zd_xl e ON a.xl = e.dm
   LEFT JOIN t_zd_xw f ON a.xw = f.dm
   LEFT JOIN t_zd_zc g ON a.zc = g.dm
   LEFT JOIN t_xt_department h ON a.xy = h.dw
   LEFT JOIN t_zd_xsh i ON a.xsh = i.dm
   LEFT JOIN t_zd_jys j ON a.jys = j.dm;

ALTER TABLE v_pk_jsxx
  OWNER TO jwxt;
COMMENT ON VIEW v_pk_jsxx
  IS '教师信息视图';

课程专业信息：
CREATE OR REPLACE VIEW v_pk_kczyxx AS 
 SELECT a.nd, a.xq, a.nj, a.zsjj, a.zy, a.pt, a.xz, a.xl, a.kcxh, b.kch, c.kcmc, c.kcywmc, c.xs, c.xf, d.cdbh, d.xqh, d.ksz, d.jsz, d.zc, d.ksj, d.jsj, d.jsgh, e.xm AS jsxm, d.hb, d.rs, a.kkxy, ( SELECT f.mc
           FROM t_zd_khfs f
      JOIN t_jx_jxjh g ON f.dm = g.kh
     WHERE a.zy = g.zy AND a.nj = g.nj AND a.zsjj = g.zsjj AND b.kch = g.kch) AS kh, a.bz
   FROM t_pk_kczy a
   LEFT JOIN t_pk_jxrw b ON a.kcxh = b.kcxh AND a.nd = b.nd AND a.xq = b.xq AND b.id = 1
   LEFT JOIN t_jx_kc c ON b.kch = c.kch
   LEFT JOIN t_pk_kb d ON a.nd = d.nd AND a.xq = d.xq AND a.kcxh = d.kcxh
   LEFT JOIN t_pk_js e ON d.jsgh = e.jsgh::bpchar;

ALTER TABLE v_pk_kczyxx
  OWNER TO jwxt;
COMMENT ON VIEW v_pk_kczyxx
  IS '课程专业信息视图';