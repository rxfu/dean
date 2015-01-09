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
    zt character varying(8));
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
  student_rec RECORD;
  course_rec RECORD;
  course_kcb tp_kcb;
  n_count INTEGER;
  c_time VARCHAR;
  c_year VARCHAR;
  c_term VARCHAR;
  o_exists VARCHAR;
BEGIN
  EXECUTE 'SELECT value FROM t_xt WHERE id = ' || quote_literal('XK_SJ') INTO c_time;
  c_year := substring(c_time from 1 for 4);
  c_term := substring(c_time from 5 for 1);
  
  IF ARRAY['Q'] = i_platform AND ARRAY['X'] = i_property THEN
    o_exists = 'NOT EXISTS';
  ELSE
    o_exists = 'pt = ANY($1) AND xz = ANY($2) AND EXISTS';
  END IF;
  
  FOR course_rec IN EXECUTE format('SELECT * FROM t_xk_kxkcxx a WHERE a.nd = %L AND a.xq = %L AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = %L) AND ' || o_exists || ' (SELECT nj, zyh, zsjj FROM v_xk_xsjbxx c WHERE a.nj = c.nj AND a.zy = c.zyh AND a.zsjj = c.zsjj AND xh = %3$L)', c_year, c_term, i_sno) USING i_platform, i_property LOOP
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
    course_kcb.zt := 'ENABLE';

    EXECUTE format('SELECT count(*) FROM t_xk_xkxx WHERE kch = %L AND xh = %L AND nd = %L', course_kcb.kch, i_sno, c_year) INTO n_count;
    IF n_count > 0 THEN
      course_kcb.zt := 'SELECTED';
    END IF;

    IF course_kcb.zt = 'ENABLE' THEN
      PERFORM format('SELECT xf FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.kch = b.kch AND xf <= 0 AND gx = ' || quote_literal('>') || ' AND kch2 = %L AND xh = %L', course_kcb.kch, i_sno);
      IF FOUND THEN
        course_kcb.zt := 'DISABLE';
      ELSE
        PERFORM format('SELECT jhrs FROM t_xk_tj WHERE kcxh = %L AND jhrs <= rs', course_kcb.kcxh);
        IF FOUND THEN
          course_kcb.zt := 'DISABLE';
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
  c_time VARCHAR;
  c_year VARCHAR;
  c_term VARCHAR;
  c_platform VARCHAR;
  c_property VARCHAR;
  course_rec RECORD;
  student_rec RECORD;
  major_rec RECORD;
BEGIN
  EXECUTE format('SELECT xh FROM t_xk_xsqf WHERE xh = %L', i_sno) INTO n_paid;
  IF FOUND THEN
    n_paid := 0;
  ELSE
    n_paid := 1;
  END IF;
  
  EXECUTE 'SELECT value FROM t_xt WHERE id = ' || quote_literal('XK_SJ') INTO c_time;
  c_year := substring(c_time from 1 for 4);
  c_term := substring(c_time from 5 for 1);
  
  EXECUTE format('SELECT xm, nj, zsjj, zy FROM t_xs_zxs WHERE xh = %L', i_sno) INTO student_rec;

  EXECUTE format('SELECT nj, zy, zsjj, pt, xz FROM t_pk_kczy WHERE nd = %L AND xq = %L AND kcxh = %L', c_year, c_term, i_cno) INTO major_rec;
  IF FOUND THEN
    IF major_rec.nj = student_rec.nj AND major_rec.zy = student_rec.zy AND major_rec.zsjj = student_rec.zsjj THEN
      c_platform = major_rec.pt;
      c_property = major_rec.xz;
    ELSE
      c_platform = 'Q';
      c_property = 'X';
    END IF;
  ELSE
    RETURN FALSE;
  END IF;
  
  EXECUTE format('SELECT * FROM t_xk_kxkcxx WHERE nj = %L AND zsjj = %L AND zy = %L AND nd = %L AND xq = %L AND kcxh = %L', student_rec.nj, student_rec.zsjj, student_rec.zy, c_year, c_term, i_cno) INTO course_rec;

  EXECUTE format('INSERT INTO t_xk_xkxx(xh, xm, nd, xq, kcxh, kch, pt, xz, xl, jsgh, xf, sf, zg, cx, bz, sj, kkxy) VALUES(%L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L, %L', i_sno, student_rec.xm, c_year, c_term, i_cno, course_rec.kch, c_platform, c_property, course_rec.xl, course_rec.jsgh, course_rec.xf, n_paid, course_rec.bz, '0', '0', CURRENT_TIMESTAMP, course_rec.kkxy);
  EXECUTE format('UPDATE t_xk_tj SET rs = rs + 1 WHERE kcxh = %L', i_cno);

  RETURN TRUE;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_xzkc_save(character varying, character varying, character varying, character varying)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xzkc_save(character varying, character varying, character varying, character varying) IS '选择课程';

select * from p_xk_hqkcb('201110100122','2012','1','1','2010','0500101','J','B')
select * from p_kxkcb_sel('201110100122','2011', '0500101', '1', '{Q}','{X}')
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