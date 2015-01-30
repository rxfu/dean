课程基本信息：
CREATE OR REPLACE VIEW v_xk_kcxx AS 
 SELECT DISTINCT a.kch,
    a.kcmc,
    a.kcywmc,
    a.xf,
    a.xs,
    a.kcjj,
    b.jc,
    b.cks,
    d.mc AS kh,
    e.bl
   FROM t_jx_kc a
     LEFT JOIN t_jx_kc_xx b ON a.kch::text = b.kch::text
     LEFT JOIN t_jx_jxjh c ON a.kch::text = c.kch::text
     LEFT JOIN t_zd_khfs d ON c.kh::text = d.dm::text
     LEFT JOIN ( SELECT t_jx_cjfs.fs,
            string_agg((t_jx_cjfs.bl / 10)::text, ':'::text) AS bl
           FROM t_jx_cjfs
          GROUP BY t_jx_cjfs.fs) e ON c.fs::text = e.fs::text
  WHERE a.zt::bpchar = '1'::bpchar
  ORDER BY a.kch;

ALTER TABLE v_xk_kcxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_kcxx
  IS '课程基本信息视图';

学生已选课程表：
CREATE OR REPLACE VIEW v_xk_xskcb AS 
 SELECT a.xh,
    a.nd,
    a.xq,
    a.kcxh,
    a.kch,
    b.kcmc,
    b.kcywmc,
    a.xf,
    g.xm AS jsxm,
    e.mc AS xqh,
    f.jxl,
    f.mc AS jsmc,
    c.ksz,
    c.jsz,
    c.zc,
    c.ksj,
    c.jsj,
    a.kkxy
   FROM t_xk_xkxx a
     LEFT JOIN t_jx_kc b ON a.kch::text = b.kch::text
     LEFT JOIN t_pk_kb c ON a.nd::text = c.nd::text AND a.xq::text = c.xq::text AND a.kcxh::text = c.kcxh::text
     LEFT JOIN t_zd_xqh e ON c.xqh::text = e.dm::text
     LEFT JOIN t_js_jsxx f ON c.cdbh::text = f.jsh::text
     LEFT JOIN t_pk_js g ON a.jsgh::bpchar = g.jsgh::bpchar;

ALTER TABLE v_xk_xskcb
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xskcb
  IS '学生已选课程表视图';

学生基本信息：
CREATE OR REPLACE VIEW v_xk_xsjbxx AS 
 SELECT a.xh,
    a.xm,
    b.mc AS xy,
    c.xq AS xqh,
    a.zy AS zyh,
    d.mc AS zy,
    a.nj,
    a.zsjj,
    a.xz,
    a.byfa
   FROM t_xs_zxs a
     JOIN t_xt_department b ON a.xy::text = b.dw::text
     LEFT JOIN t_xk_xyxq c ON a.xy::text = c.xy::text
     JOIN t_jx_zy d ON a.zy::text = d.zy::text;

ALTER TABLE v_xk_xsjbxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xsjbxx
  IS '学生基本信息视图';

学生详细信息：
CREATE OR REPLACE VIEW v_xk_xsxx AS 
 SELECT a.xh,
    a.xm,
    a.cym,
    a.xmpy,
    b.mc AS xb,
    a.csny,
    c.mc AS mz,
    d.mc AS gj,
    e.mc AS xy,
    f.mc AS xs,
    g.mc AS zy,
    a.zyfs,
    h.mc AS zy2,
    i.mc AS fxzy,
    a.bj,
    a.xz,
    j.mc AS xjzt,
    k.mc AS zylb,
    a.rxrq,
    l.mc AS rxfs,
    m.mc AS bxxs,
    n.mc AS bxlx,
    o.mc AS xxxs,
    p.mc AS zsjj,
    q.mc AS syd,
    a.jg,
    a.csd,
    r.mc AS zzmm,
    a.jrrq,
    a.tc,
    a.zxmc,
    a.jzxm,
    a.yzbm,
    a.jtdz,
    a.lxdh,
    s.mc AS zjlx,
    a.sfzh,
    a.nj,
    a.sfldm,
    a.zxwyyz,
    a.zxwyjb,
    a.jsjdj,
    a.bz,
    a.zp,
    a.byfa,
    a.hcdz,
    a.ksh
   FROM t_xs_zxs a
     LEFT JOIN t_zd_xb b ON a.xbdm::text = b.dm::text
     LEFT JOIN t_zd_mz c ON a.mzdm::text = c.dm::text
     LEFT JOIN t_zd_gj d ON a.gj::text = d.dm::text
     LEFT JOIN t_xt_department e ON a.xy::text = e.dw::text
     LEFT JOIN t_zd_xsh f ON a.xsh::text = f.dm::text
     LEFT JOIN t_jx_zy g ON a.zy::text = g.zy::text
     LEFT JOIN t_jx_zy h ON a.zy2::text = h.zy::text
     LEFT JOIN t_jx_zy i ON a.fxzy::text = i.zy::text
     LEFT JOIN t_zd_xjzt j ON a.xjzt::bpchar = j.dm::bpchar
     LEFT JOIN t_zd_zylb k ON a.zylb::text = k.dm::text
     LEFT JOIN t_zd_rxfs l ON a.rxfs::text = l.dm::text
     LEFT JOIN t_zd_bxxs m ON a.bxxs::text = m.dm::text
     LEFT JOIN t_zd_bxlx n ON a.bxlx::text = n.dm::text
     LEFT JOIN t_zd_xxxs o ON a.xxxs::text = o.dm::text
     LEFT JOIN t_zd_zsjj p ON a.zsjj::text = p.dm::text
     LEFT JOIN t_zd_syszd q ON a.syszd::bpchar = q.dm::bpchar
     LEFT JOIN t_zd_zzmm r ON a.zzmm::text = r.dm::text
     LEFT JOIN t_zd_zjlx s ON a.zjlx::text = s.dm::text;

ALTER TABLE v_xk_xsxx
  OWNER TO jwxt;
COMMENT ON VIEW v_xk_xsxx
  IS '学生详细信息视图';

教学计划信息：
CREATE OR REPLACE VIEW v_xk_jxjh AS 
 SELECT a.zy,
    a.nj,
    a.zsjj,
    a.kch,
    b.kcmc,
    b.kcywmc,
    c.mc AS pt,
    d.mc AS xz,
    a.xl,
    a.llxf,
    a.syxf,
    a.zxf,
    a.llxs,
    a.syxs,
    a.llxs + a.syxs AS zxs,
    a.kxq,
    e.mc AS kkxy,
    f.mc AS kh,
    a.fs,
    a.lx
   FROM t_jx_jxjh a
     LEFT JOIN t_jx_kc b ON a.kch::text = b.kch::text
     LEFT JOIN t_zd_pt c ON a.pt::text = c.dm::text
     LEFT JOIN t_zd_xz d ON a.xz::text = d.dm::text
     LEFT JOIN t_xt_department e ON a.kxy::text = e.dw::text
     LEFT JOIN t_zd_khfs f ON a.kh::text = f.dm::text
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
    h.jhrs,
    h.rs,
    e.kkxy,
    g.mc AS kh,
    e.bz
   FROM t_pk_kb a
     LEFT JOIN t_pk_js b ON b.jsgh::text = a.jsgh::text
     LEFT JOIN t_pk_jxrw c ON c.kcxh::text = a.kcxh::text AND c.nd::text = a.nd::text AND c.xq::text = a.xq::text AND c.id = 1
     LEFT JOIN t_jx_kc d ON d.kch::text = c.kch::text
     LEFT JOIN t_pk_kczy e ON e.nd::text = a.nd::text AND e.xq::text = a.xq::text AND e.kcxh::text = a.kcxh::text
     LEFT JOIN t_jx_jxjh f ON f.zy::text = e.zy::text AND f.nj::text = e.nj::text AND f.zsjj::text = e.zsjj::text AND f.kch::text = c.kch::text
     LEFT JOIN t_zd_khfs g ON g.dm::text = f.kh::text
     LEFT JOIN t_xk_tj h ON h.kcxh::text = a.kcxh::text;

ALTER TABLE v_xk_kxkcxx
  OWNER TO jwxt;
GRANT ALL ON TABLE v_xk_kxkcxx TO jwxt;
GRANT ALL ON TABLE v_xk_kxkcxx TO kongsir;
COMMENT ON VIEW v_xk_kxkcxx
  IS '可选课程信息视图';

教师信息：
CREATE OR REPLACE VIEW v_pk_jsxx AS 
 SELECT a.jsgh,
    a.xm,
    b.mc AS xb,
    a.csrq,
    c.mc AS gj,
    d.mc AS zjlx,
    a.sfzh,
    e.mc AS xl,
    f.mc AS xw,
    g.mc AS zc,
    a.zy,
    a.jj,
    h.mc AS xy,
    i.mc AS xs,
    j.mc AS jys,
    a.zt
   FROM t_pk_js a
     LEFT JOIN t_zd_xb b ON a.xb::text = b.dm::text
     LEFT JOIN t_zd_gj c ON a.gj::text = c.dm::text
     LEFT JOIN t_zd_zjlx d ON a.zjlx::text = d.dm::text
     LEFT JOIN t_zd_xl e ON a.xl::text = e.dm::text
     LEFT JOIN t_zd_xw f ON a.xw::text = f.dm::text
     LEFT JOIN t_zd_zc g ON a.zc::text = g.dm::text
     LEFT JOIN t_xt_department h ON a.xy::text = h.dw::text
     LEFT JOIN t_zd_xsh i ON a.xsh::text = i.dm::text
     LEFT JOIN t_zd_jys j ON a.jys::text = j.dm::text;

ALTER TABLE v_pk_jsxx
  OWNER TO jwxt;
COMMENT ON VIEW v_pk_jsxx
  IS '教师信息视图';

课程专业信息：
CREATE OR REPLACE VIEW v_pk_kczyxx AS 
 SELECT a.nd,
    a.xq,
    b.zsjj,
    a.kcxh,
    g.kch,
    h.kcmc,
    h.kcywmc,
    i.llxs + i.syxs AS xs,
    i.zxf AS xf,
    b.nj,
    b.zy AS zyh,
    c.mc AS zy,
    d.mc AS pt,
    e.mc AS xz,
    f.mc AS kkxy,
    g.jsgh,
    g.cjfs,
    g.id
   FROM t_pk_kb a
     LEFT JOIN t_pk_kczy b ON b.nd::text = a.nd::text AND b.xq::text = a.xq::text AND b.kcxh::text = a.kcxh::text
     LEFT JOIN t_jx_zy c ON c.zy::text = b.zy::text
     LEFT JOIN t_zd_pt d ON d.dm::text = b.pt::text
     LEFT JOIN t_zd_xz e ON e.dm::text = b.xz::text
     LEFT JOIN t_xt_department f ON f.dw::text = b.kkxy::text
     LEFT JOIN t_pk_jxrw g ON g.kcxh::text = a.kcxh::text AND g.nd::text = a.nd::text AND g.xq::text = a.xq::text
     LEFT JOIN t_jx_kc h ON h.kch::text = g.kch::text
     LEFT JOIN t_jx_jxjh i ON i.zy::text = b.zy::text AND i.nj::text = b.nj::text AND i.zsjj::text = b.zsjj::text AND i.kch::text = g.kch::text;

ALTER TABLE v_pk_kczyxx
  OWNER TO jwxt;
GRANT ALL ON TABLE v_pk_kczyxx TO jwxt;
GRANT ALL ON TABLE v_pk_kczyxx TO kongsir;
COMMENT ON VIEW v_pk_kczyxx
  IS '课程专业信息视图';

学生成绩录入表：
CREATE OR REPLACE VIEW v_cj_xscjlr AS 
 SELECT a.xh,
    a.xm,
    a.kcxh,
    b.kch,
    c.kcmc,
    a.kcpt,
    a.kcxz,
    a.xl,
    a.nd,
    a.xq,
    a.kh,
    a.cj1,
    a.cj2,
    a.cj3,
    a.cj4,
    a.cj5,
    a.cj6,
    a.zpcj,
    b.jsgh,
    b.cjfs,
    a.kszt,
    d.mc AS zy,
    a.tjzt,
    e.mc AS kkxy
   FROM t_cj_web a
     LEFT JOIN t_pk_jxrw b ON b.kcxh::text = a.kcxh::text AND b.nd::text = a.nd::text AND b.xq::text = a.xq::text
     LEFT JOIN t_jx_kc c ON c.kch::text = b.kch::text
     LEFT JOIN t_jx_zy d ON d.zy::text = a.zy::text
     LEFT JOIN t_xt_department e ON e.dw::text = a.kkxy::text
     LEFT JOIN t_pk_kczy f ON f.nd::text = a.nd::text AND f.xq::text = a.xq::text AND f.kcxh::text = a.kcxh::text AND f.zy::text = a.zy::text;

ALTER TABLE v_cj_xscjlr
  OWNER TO jwxt;
GRANT ALL ON TABLE v_cj_xscjlr TO jwxt;
GRANT ALL ON TABLE v_cj_xscjlr TO kongsir;
COMMENT ON VIEW v_cj_xscjlr
  IS '学生成绩录入信息视图';

成绩方式信息视图：
CREATE OR REPLACE VIEW v_cj_cjfs AS 
 SELECT b.nd,
    b.xq,
    b.kcxh,
    b.kch,
    b.jsgh,
    a.fs,
    a.khmc,
    a.ywmc,
    a.id,
    a.idm,
    a.mf,
    a.bl
   FROM t_jx_cjfs a
     JOIN t_pk_jxrw b ON b.cjfs::text = a.fs::text AND b.id = a.id;

ALTER TABLE v_cj_cjfs
  OWNER TO jwxt;
GRANT ALL ON TABLE v_cj_cjfs TO jwxt;
GRANT ALL ON TABLE v_cj_cjfs TO kongsir;
COMMENT ON VIEW v_cj_cjfs
  IS '成绩方式信息视图';

学生成绩单：
CREATE OR REPLACE VIEW v_cj_xscj AS 
 SELECT a.xh,
    a.xm,
    a.nd,
    a.xq,
    a.kch,
    b.kcmc,
    b.kcywmc,
    a.cj,
    a.xf,
    a.jd,
    c.mc AS pt,
    d.mc AS xz,
    e.mc AS kh,
    a.kszt
   FROM t_cj_zxscj a
     LEFT JOIN t_jx_kc b ON b.kch::text = a.kch::text
     LEFT JOIN t_zd_pt c ON c.dm::text = a.pt::text
     LEFT JOIN t_zd_xz d ON d.dm::text = a.kcxz::text
     LEFT JOIN t_zd_khfs e ON e.dm::text = a.kh::text;

ALTER TABLE v_cj_xscj
  OWNER TO jwxt;
COMMENT ON VIEW v_cj_xscj
  IS '学生成绩单视图';

学生成绩详单：
CREATE OR REPLACE VIEW v_cj_xsgccj AS 
 SELECT a.xh,
    a.xm,
    a.nd,
    a.xq,
    a.kcxh,
    b.kch,
    c.kcmc,
    c.kcywmc,
    a.cj1,
    a.cj2,
    a.cj3,
    a.cj4,
    a.cj5,
    a.cj6,
    a.zpcj,
    d.mc AS pt,
    e.mc AS xz,
    a.xl,
    f.mc AS kh,
    b.cjfs,
    a.kszt,
    a.zy,
    a.tjzt,
    b.jsgh,
    a.kkxy
   FROM t_cj_lscj a
     LEFT JOIN t_pk_jxrw b ON b.kcxh::text = a.kcxh::text AND b.nd::text = a.nd::text AND b.xq::text = a.xq::text
     LEFT JOIN t_jx_kc c ON c.kch::text = b.kch::text
     LEFT JOIN t_zd_pt d ON d.dm::text = a.kcpt::text
     LEFT JOIN t_zd_xz e ON e.dm::text = a.kcxz::text
     LEFT JOIN t_zd_khfs f ON f.dm::text = a.kh::text;

ALTER TABLE v_cj_xsgccj
  OWNER TO jwxt;
COMMENT ON VIEW v_cj_xsgccj
  IS '学生成绩详细信息视图';