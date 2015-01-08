选课课表：
-- Type: tp_xk_kcb

-- DROP TYPE tp_xk_kcb;

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

-- Function: p_xk_hqkcb(character, character, character, character, character, character, character, character)

-- DROP FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character);

CREATE OR REPLACE FUNCTION p_kxkcb_sel(
    i_sno character,
    i_platform character,
    i_property character)
  RETURNS SETOF tp_kcb AS
$BODY$DECLARE
  student_rec RECORD;
  course_rec RECORD;
  course_kcb tp_kcb;
  n_count INTEGER;
  c_time VARCHAR;
  c_year VARCHAR;
  c_term VARCHAR;
BEGIN
  EXECUTE 'SELECT value FROM t_xt WHERE id = ' || quote_literal('XK_SJ') INTO c_time;
  c_year := substring(c_time from 1 for 4);
  c_term := substring(c_time from 5 for 1);
  
  EXECUTE 'SELECT zsjj, nj, zyh FROM v_xk_xsjbxx WHERE xh = $1' INTO student_rec USING i_sno;
  
  FOR course_rec IN EXECUTE 'SELECT * FROM t_xk_kxkcxx a WHERE nd = $1 AND xq = $2 AND zsjj = $3 AND nj = $4 AND zy = $5 AND pt = ANY($6) AND xz = ANY($7) AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = $8)' USING c_year, c_term, student_rec.zsjj, student_rec.nj, student_rec.zyh, i_platform, i_property, i_sno LOOP
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

    EXECUTE 'SELECT count(*) FROM t_xk_xkxx WHERE kch = $1 AND xh = $2 AND nd = $3' INTO n_count USING course_kcb.kch, i_sno, c_year;
    IF n_count > 0 THEN
      course_kcb.zt := 'SELECTED';
    END IF;

    IF course_kcb.zt = 'ENABLE' THEN
      EXECUTE 'SELECT xf FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.kch = b.kch AND xf <= 0 AND gx = ' || quote_literal('>') || ' AND kch2 = $1 AND xh = $2' USING course_kcb.kch, i_sno;
      IF FOUND THEN
        course_kcb.zt := 'DISABLE';
      ELSE
        EXECUTE 'SELECT jhrs FROM t_xk_tj WHERE kcxh = $1 AND jhrs <= rs' USING course_kcb.kcxh;
        IF FOUND THEN
          course_kcb.zt := 'DISABLE';
        END IF;
      END IF;
    END IF;

    RETURN NEXT course_kcb;
  END LOOP;
END$BODY$
  LANGUAGE plpgsql IMMUTABLE
  COST 100
  ROWS 1000;
ALTER FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character) IS '获取可选课程列表';

-- Function: p_xk_xzkc(character, character, character, character)

-- DROP FUNCTION p_xk_xzkc(character, character, character, character);

CREATE OR REPLACE FUNCTION p_xzkc_save(
    i_sno character,
    i_cno character,
    i_platform character,
    i_property character)
  RETURNS void AS
$BODY$DECLARE
  n_paid INTEGER;
  c_time VARCHAR;
  c_year VARCHAR;
  c_term VARCHAR;
  course_rec RECORD;
  student_rec RECORD;
BEGIN
  EXECUTE 'SELECT xh FROM t_xk_xsqf WHERE xh = $1' INTO n_paid USING i_sno;
  IF FOUND THEN
    c_paid := 0;
  ELSE
    c_paid := 1;
  END IF;
  
  EXECUTE 'SELECT value FROM t_xt WHERE id = ' || quote_literal('XK_SJ') INTO c_time;
  c_year := substring(c_time from 1 for 4);
  c_term := substring(c_time from 5 for 1);
  
  EXECUTE 'SELECT xm, nj, zsjj, zy FROM t_xs_zxs WHERE xh = $1' INTO student_rec USING i_sno;
  
  EXECUTE 'SELECT a.jsgh, a.ksz, a.jsz, a.zc, a.ksj, a.jsj, b.kch, c.pt, c.xz, c.xl, c.kkxy, c.bz, d.zxf FROM t_pk_kb a LEFT JOIN t_pk_jxrw b ON a.nd = b.nd AND a.xq = b.xq AND a.kcxh = b.kcxh AND a.jsgh = b.jsgh LEFT JOIN t_pk_kczy c ON a.nd = c.nd AND a.xq = c.xq AND a.kcxh = c.kcxh AND c.nj = $1 AND c.zsjj = $2 AND c.zy = $3 LEFT JOIN t_jx_jxjh d ON d.zy = c.zy AND d.nj = c.nj AND d.zsjj = c.zsjj AND d.kch = b.kch WHERE a.nd = $4 AND a.xq = $5 AND a.kcxh = $6' INTO course_rec USING student_rec.nj, student_rec.zsjj, student_rec.zy, c_year, c_term, i_cno;

  EXECUTE 'INSERT INTO t_xk_xkxx(xh, xm, nd, xq, kcxh, kch, pt, xz, xl, jsgh, xf, sf, zg, cx, bz, sj, kkxy) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16,$17)' USING i_sno, student_rec.xm, c_year, c_term, cno, course_rec.kch, course_rec.pt, course_rec.xz, course_rec.xl, course_rec.jsgh, course_rec.zxf, c_paid, course_rec.bz, '0', '0', CURRENT_TIMESTAMP, course_rec.kkxy;
  EXECUTE 'UPDATE t_xk_tj SET rs = rs + 1 WHERE kcxh = $1' USING i_cno;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_xk_xzkc(character, character, character, character)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xk_xzkc(character, character, character, character) IS '选择课程';

select * from p_xk_hqkcb('201110100122','2012','1','1','2010','0500101','J','B')
select * from p_kxkcb_sel('201110100122','J','B')
SELECT * FROM t_xk_kxkcxx a
 WHERE nd = '2012'
  AND xq = '1'
   AND zsjj = '1'
    AND nj = '2011'
     AND zy = '0500101'
      AND pt IN ('J', 'T')
       AND xz IN ('B')
        AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = '201110100122')
