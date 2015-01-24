选课课表：
CREATE TYPE tp_kcb AS
   (kch character varying(8),
    kcxh character varying(12),
    kcmc character varying(60),
    kcywmc character varying(180),
    xf numeric(5,1),
    kh character varying(4),
    xl character varying(4),
    jsgh character varying(10),
    jsxm character varying(60),
    zg character varying(1),
    rs integer,
    kkxy character varying(2),
    xqh character varying(6),
    hb character varying(12),
    ksz integer,
    jsz integer,
    zc integer,
    ksj integer,
    jsj integer,
    cdbh character varying(7),
    zt character varying(1));
ALTER TYPE tp_kcb
  OWNER TO jwxt;
COMMENT ON TYPE tp_kcb
  IS '可选课程列表';

列出可选课程：
CREATE OR REPLACE FUNCTION p_kxkcb_sel(
    i_sno text,
    i_platform text[],
    i_property text[],
    i_grade text[],
    i_speciality text[],
    i_season text)
  RETURNS SETOF tp_kcb AS
$BODY$DECLARE
  course_rec RECORD;
  course_kcb tp_kcb;
  c_year TEXT;
  c_term TEXT;
BEGIN
  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NOT Setup Selective Time';
    RETURN;
  END IF;
    
  FOR course_rec IN EXECUTE format('SELECT * FROM %I WHERE nd = %L AND xq = %L AND zsjj = %L AND pt = ANY($2) AND xz = ANY($3) AND nj = ANY($3) AND zy = ANY($4)', 'v_xk_kxkcxx', c_year, c_term, i_season) USING i_platform, i_property, i_grade, i_speciality LOOP
    PERFORM 1 FROM t_cj_zxscj WHERE kch = course_rec.kch AND xh = i_sno;
    CONTINUE WHEN FOUND;

    course_kcb.kch := course_rec.kch;
    course_kcb.kcxh := course_rec.kcxh;
    course_kcb.kcmc := course_rec.kcmc;
    course_kcb.kcywmc := course_rec.kcywmc;
    course_kcb.xf := course_rec.xf;
    course_kcb.kh := course_rec.kh;
    course_kcb.xl := course_rec.xl;
    course_kcb.jsgh := course_rec.jsgh;
    course_kcb.jsxm := course_rec.jsxm;
    course_kcb.zg := course_rec.bz;
    course_kcb.rs := course_rec.rs;
    course_kcb.kkxy := course_rec.kkxy;
    course_kcb.xqh := course_rec.xqh;
    course_kcb.hb := course_rec.hb;
    course_kcb.ksz := course_rec.ksz;
    course_kcb.jsz := course_rec.jsz;
    course_kcb.zc := course_rec.zc;
    course_kcb.ksj := course_rec.ksj;
    course_kcb.jsj := course_rec.jsj;
    course_kcb.cdbh := course_rec.cdbh;
    course_kcb.zt := '1';

    PERFORM 1 FROM t_xk_xkxx WHERE kcxh = course_kcb.kcxh AND xh = i_sno AND nd = c_year AND xq = c_term;
    IF FOUND THEN
      course_kcb.zt := '2';
    END IF;

    IF course_kcb.zt = '1' THEN
      PERFORM 1 FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.kch = b.kch AND xf <= 0 AND gx = '>' AND kch2 = course_kcb.kch AND xh = i_sno;
      IF FOUND THEN
        course_kcb.zt := '0';
      ELSE
        PERFORM 1 FROM t_xk_tj WHERE kcxh = course_kcb.kcxh AND jhrs > 0 AND jhrs <= rs;
        IF FOUND THEN
          course_kcb.zt := '0';
        END IF;
      END IF;
    END IF;

    RETURN NEXT course_kcb;
  END LOOP;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION p_kxkcb_sel(text, text[], text[], text[], text[], text)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_kxkcb_sel(text, text[], text[], text[], text[], text) IS '列出可选课程';

列出重修课程：
CREATE OR REPLACE FUNCTION p_cxkcb_sel(i_sno text)
  RETURNS SETOF tp_kcb AS
$BODY$DECLARE
  course_rec RECORD;
  course_kcb tp_kcb;
  c_year TEXT;
  c_term TEXT;
  c_query TEXT;
BEGIN
  PERFORM 1 FROM t_xs_zxs WHERE xh = i_sno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO STUDENT!';
    RETURN;
  END IF;

  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NOT Setup Selective Time';
    RETURN;
  END IF;

  FOR course_rec IN EXECUTE format('SELECT * FROM %I a WHERE EXISTS (SELECT 1 FROM t_cj_zxscj WHERE kch = a.kch AND xh = %L) AND nd = %L AND xq = %L', 'v_xk_kxkcxx', i_sno, c_year, c_term) LOOP
    course_kcb.kch := course_rec.kch;
    course_kcb.kcxh := course_rec.kcxh;
    course_kcb.kcmc := course_rec.kcmc;
    course_kcb.kcywmc := course_rec.kcywmc;
    course_kcb.xf := course_rec.xf;
    course_kcb.kh := course_rec.kh;
    course_kcb.xl := course_rec.xl;
    course_kcb.jsgh := course_rec.jsgh;
    course_kcb.jsxm := course_rec.jsxm;
    course_kcb.zg := course_rec.bz;
    course_kcb.rs := course_rec.rs;
    course_kcb.kkxy := course_rec.kkxy;
    course_kcb.xqh := course_rec.xqh;
    course_kcb.hb := course_rec.hb;
    course_kcb.ksz := course_rec.ksz;
    course_kcb.jsz := course_rec.jsz;
    course_kcb.zc := course_rec.zc;
    course_kcb.ksj := course_rec.ksj;
    course_kcb.jsj := course_rec.jsj;
    course_kcb.cdbh := course_rec.cdbh;
    course_kcb.zt := '1';

    PERFORM 1 FROM t_xk_xkxx WHERE kch = course_kcb.kch AND xh = i_sno AND nd = c_year AND xq = c_term;
    IF FOUND THEN
      course_kcb.zt := '2';
    END IF;

    PERFORM 1 FROM t_xk_xksq WHERE kcxh = course_kcb.kcxh AND xh = i_sno AND nd = c_year AND xq = c_term AND sh = '0';
    IF FOUND THEN
      course_kcb.zt := '3';
    END IF;

    RETURN NEXT course_kcb;
  END LOOP;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION p_cxkcb_sel(text)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_cxkcb_sel(text) IS '列出重修课程';

选择课程：
CREATE OR REPLACE FUNCTION p_xzkc_save(
    i_sno text,
    i_cno text)
  RETURNS boolean AS
$BODY$DECLARE
  n_paid INTEGER;
  c_year TEXT;
  c_term TEXT;
  c_platform TEXT;
  c_property TEXT;
  course_rec RECORD;
  student_rec RECORD;
  major_rec RECORD;
  n_count INTEGER;
BEGIN
  PERFORM 1 FROM t_xk_tj WHERE kcxh = i_cno AND jhrs < rs;
  IF FOUND THEN
    RAISE EXCEPTION 'Too Many Students Selected This Course!';
    RETURN FALSE;
  END IF;

  SELECT xm, nj, zsjj, zy INTO student_rec FROM t_xs_zxs WHERE xh = i_sno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO STUDENT!';
    RETURN FALSE;
  END IF;
  
  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NOT Setup Selective Time';
    RETURN FALSE;
  END IF;

  SELECT nj, zy, zsjj, pt, xz INTO major_rec FROM t_pk_kczy WHERE nd = c_year AND xq = c_term AND kcxh = i_cno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO COURSE!';
    RETURN FALSE;
  ELSIF major_rec.nj = student_rec.nj AND major_rec.zy = student_rec.zy AND major_rec.zsjj = student_rec.zsjj THEN
    c_platform := major_rec.pt;
    c_property := major_rec.xz;
  ELSE
    c_platform := 'Q';
    c_property := 'X';
  END IF;

  PERFORM 1 FROM t_xk_xsqf WHERE xh = i_sno;
  IF FOUND THEN
    n_paid := 0;
  ELSE
    n_paid := 1;
  END IF;

  EXECUTE format('SELECT kch, xl, jsgh, xf, bz, kkxy FROM %I WHERE nj = %L AND zsjj = %L AND zy = %L AND nd = %L AND xq = %L AND kcxh = %L', 'v_xk_kxkcxx', student_rec.nj, student_rec.zsjj, student_rec.zy, c_year, c_term, i_cno) INTO course_rec;
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'NO COURSE!';
    RETURN FALSE;
  END IF;

  EXECUTE format('INSERT INTO %I(xh, xm, nd, xq, kcxh, kch, pt, xz, xl, jsgh, xf, sf, zg, cx, bz, sj, kkxy) VALUES(%L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L)', 't_xk_xkxx', i_sno, student_rec.xm, c_year, c_term, i_cno, course_rec.kch, c_platform, c_property, course_rec.xl, course_rec.jsgh, course_rec.xf, n_paid, course_rec.bz, '0', '0', CURRENT_TIMESTAMP, course_rec.kkxy);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Insert FAILED!';
    RETURN FALSE;
  END IF;

  EXECUTE format('UPDATE %I SET rs = rs + 1 WHERE kcxh = %L', 't_xk_tj', i_cno);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Update FAILED!';
    RETURN FALSE;
  END IF;

  RETURN TRUE;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_xzkc_save(text, text)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xzkc_save(text, text) IS '选择课程';

删除选课：
CREATE OR REPLACE FUNCTION p_scxk_del(
    i_sno text,
    i_cno text)
  RETURNS boolean AS
$BODY$DECLARE
  c_year TEXT;
  c_term TEXT;
  n_count INTEGER;
BEGIN
  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NOT Setup Selective Time';
    RETURN FALSE;
  END IF;

  PERFORM 1 FROM t_xk_xkxx WHERE nd = c_year AND xq = c_term AND xh = i_sno AND kcxh = i_cno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO RECORD';
    RETURN FALSE;
  END IF;

  EXECUTE format('DELETE FROM %I WHERE nd = %L AND xq = %L AND xh = %L AND kcxh = %L', 't_xk_xkxx', c_year, c_term, i_sno, i_cno);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Delete FAILED!';
    RETURN FALSE;
  END IF;

  EXECUTE format('UPDATE %I SET rs = rs - 1 WHERE kcxh = %L', 't_xk_tj', i_cno);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Update FAILED!';
    RETURN FALSE;
  END IF;

  RETURN TRUE;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_scxk_del(text, text)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_scxk_del(text, text) IS '取消所选课程';

select * from p_xk_hqkcb('201110100122','2012','1','1','2010','0500101','J','B')
select * from p_kxkcb_sel('201110100122','2011', '0500101', '1', '{Q}','{X}')
select * from p_kxkcb_sel('201110100122', '{T}','{B}')
SELECT * FROM t_xk_kxkcxx a
 WHERE nd = '2012'
  AND xq = '1'
   AND zsjj = '1'
    AND nj = '2011'
     AND zy = '0500101'
      AND pt IN ('J', 'T')
       AND xz IN ('B')
        AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = '201110100122')
select p_xzkc_save('201110100122','TB1300101349','T','B')
SELECT * FROM t_xk_kxkcxx a 
WHERE nd = '2012'
 AND xq = '1'
  AND zsjj = '1'
   AND nj = '2011'
    AND zy = '0500101'
     AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = '201110100122')
      AND NOT EXISTS (SELECT nj, zyh, zsjj FROM v_xk_xsjbxx c WHERE a.nj = c.nj AND a.zy = c.zyh AND xh = '201110100122')
SELECT * FROM t_xk_kxkcxx a 
WHERE nd = '2012'
 AND xq = '1'
  AND zsjj = '1'
   AND nj = '2011'
    AND zy = '0500101'
     AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = '201110100122')
      AND pt = ANY('{T}')
       AND xz = ANY('{B}')
        AND EXISTS (SELECT nj, zyh, zsjj FROM v_xk_xsjbxx c WHERE a.nj = c.nj AND a.zy = c.zyh AND xh = '201110100122')