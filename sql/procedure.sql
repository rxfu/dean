选课课表：
-- Type: tp_kcb

-- DROP TYPE tp_kcb;

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

-- Function: p_kxkcb_sel(text, text[], text[])

-- DROP FUNCTION p_kxkcb_sel(text, text[], text[]);

CREATE OR REPLACE FUNCTION p_kxkcb_sel(
    i_sno text,
    i_platform text[],
    i_property text[])
  RETURNS SETOF tp_kcb AS
$BODY$DECLARE
  course_rec RECORD;
  course_kcb tp_kcb;
  c_year TEXT;
  c_term TEXT;
  c_query TEXT;
  c_grade TEXT;
  c_major TEXT;
  c_season TEXT;
BEGIN
  PERFORM 1 FROM t_xs_zxs WHERE xh = i_sno;
  IF NOT FOUND THEN
    RETURN;
  END IF;

  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';

  EXECUTE format('SELECT nj, zy, zsjj FROM %I WHERE xh = %L', 't_xs_zxs', i_sno) INTO c_grade, c_major, c_season;
  
  IF ARRAY['Q'] = i_platform AND ARRAY['X'] = i_property THEN
    c_query = format('SELECT * FROM %I a WHERE a.nd = %L AND a.xq = %L AND a.zsjj = %L AND EXISTS (SELECT nj, zy FROM %1$I b WHERE a.nd = b.nd AND a.xq = b.xq AND (b.nj <> %L OR b.zy <> %L))', 'v_xk_kxkcxx', c_year, c_term, c_season, c_grade, c_major);
  ELSE
    c_query = format('SELECT * FROM %I a WHERE a.nd = %L AND a.xq = %L AND a.zsjj = %L AND a.nj = %L AND a.zy = %L AND pt = ANY($1) AND xz = ANY($2)', 'v_xk_kxkcxx', c_year, c_term, c_season, c_grade, c_major);
  END IF;
  
  FOR course_rec IN EXECUTE c_query USING i_platform, i_property LOOP
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

    PERFORM 1 FROM t_xk_xkxx WHERE kch = course_kcb.kch AND xh = i_sno AND nd = c_year AND xq = c_term;
    IF FOUND THEN
      course_kcb.zt := '2';
    END IF;

    IF course_kcb.zt = '1' THEN
      PERFORM 1 FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.kch = b.kch AND xf <= 0 AND gx = '>' AND kch2 = course_kcb.kch AND xh = i_sno;
      IF FOUND THEN
        course_kcb.zt := '0';
      ELSE
        PERFORM 1 FROM t_xk_tj WHERE kcxh = course_kcb.kcxh AND jhrs <= rs;
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
ALTER FUNCTION p_kxkcb_sel(text, text[], text[])
  OWNER TO jwxt;
COMMENT ON FUNCTION p_kxkcb_sel(text, text[], text[]) IS '列出可选课程';

-- Function: p_xzkc_save(character varying, character varying, character varying, character varying)

-- DROP FUNCTION p_xzkc_save(character varying, character varying, character varying, character varying);

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
  SELECT xm, nj, zsjj, zy INTO student_rec FROM t_xs_zxs WHERE xh = i_sno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO STUDENT';
    RETURN FALSE;
  END IF;
  
  SELECT substr(value, 1, 4), substr(value, 5, 1) INTO c_year, c_term FROM t_xt WHERE id = 'XK_SJ';

  SELECT nj, zy, zsjj, pt, xz INTO major_rec FROM t_pk_kczy WHERE nd = c_year AND xq = c_term AND kcxh = i_cno;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'NO COURSE';
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

  EXECUTE format('SELECT * FROM t_xk_kxkcxx WHERE nj = %L AND zsjj = %L AND zy = %L AND nd = %L AND xq = %L AND kcxh = %L', student_rec.nj, student_rec.zsjj, student_rec.zy, c_year, c_term, i_cno) INTO course_rec;
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'NO COURSE!';
    RETURN FALSE;
  END IF;

  EXECUTE format('INSERT INTO t_xk_xkxx(xh, xm, nd, xq, kcxh, kch, pt, xz, xl, jsgh, xf, sf, zg, cx, bz, sj, kkxy) VALUES(%L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L)', i_sno, student_rec.xm, c_year, c_term, i_cno, course_rec.kch, c_platform, c_property, course_rec.xl, course_rec.jsgh, course_rec.xf, n_paid, course_rec.bz, '0', '0', CURRENT_TIMESTAMP, course_rec.kkxy);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Insert FAILED!';
    RETURN FALSE;
  END IF;

  EXECUTE format('UPDATE t_xk_tj SET rs = rs + 1 WHERE kcxh = %L', i_cno);
  GET DIAGNOSTICS n_count = ROW_COUNT;
  IF 0 >= n_count THEN
    RAISE EXCEPTION 'Update FAILED!';
    RETURN FALSE;
  END IF;

  RETURN TRUE;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_xzkc_save(character varying, character varying, character varying, character varying)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xzkc_save(character varying, character varying, character varying, character varying) IS '选择课程';

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