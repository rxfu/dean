选课课表：
-- Type: tp_xk_kcb

-- DROP TYPE tp_xk_kcb;

CREATE TYPE tp_xk_kcb AS
   (kch character(8),
    kcxh character(12),
    kcmc character varying(60),
    kcywmc character varying(180),
    xf numeric(5,1),
    kh character varying(4),
    xl character(4),
    jsgh character(10),
    jsxm character(60),
    zg character(1),
    rs integer,
    kkxy character(2),
    xqh character varying(6),
    hb character(12),
    ksz integer,
    jsz integer,
    zc integer,
    ksj integer,
    jsj integer,
    cdbh character(7),
    zt character(1));
ALTER TYPE tp_xk_kcb
  OWNER TO jwxt;
COMMENT ON TYPE tp_xk_kcb
  IS '可选课程列表';

-- Function: p_xk_hqkcb(character, character, character, character, character, character, character, character)

-- DROP FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character);

CREATE OR REPLACE FUNCTION p_xk_hqkcb(
    sno character,
    year character,
    term character,
    season character,
    grade character,
    spno character,
    platform character,
    property character)
  RETURNS SETOF tp_xk_kcb AS
$BODY$DECLARE
  rec RECORD;
  kcb tp_xk_kcb;
  query VARCHAR;
  record_count INTEGER;
BEGIN
  query := 'SELECT * FROM t_xk_kxkcxx a WHERE nd = ' || quote_literal(year) || ' AND xq = ' || quote_literal(term) || ' AND zsjj = ' || quote_literal(season) || ' AND nj = ' || quote_literal(grade) || ' AND zy = ' || quote_literal(spno) || ' AND pt = ' || quote_literal(platform) || ' AND xz = ' || quote_literal(property) || ' AND NOT EXISTS (SELECT kch FROM t_cj_zxscj b WHERE a.kch = b.kch AND b.xh = ' || quote_literal(sno) || ')';

  FOR rec IN EXECUTE query LOOP
    kcb.kch := rec.kch;
    kcb.kcxh := rec.kcxh;
    kcb.kcmc := rec.kcmc;
    kcb.kcywmc := rec.kcywmc;
    kcb.xf := rec.xf;
    kcb.kh := rec.kh;
    kcb.xl := rec.xl;
    kcb.jsgh := rec.jsgh;
    kcb.jsxm := rec.jsxm;
    kcb.zg := rec.bz;
    kcb.rs := rec.rs;
    kcb.kkxy := rec.kkxy;
    kcb.xqh := rec.xqh;
    kcb.hb := rec.hb;
    kcb.ksz := rec.ksz;
    kcb.jsz := rec.jsz;
    kcb.zc := rec.zc;
    kcb.ksj := rec.ksj;
    kcb.jsj := rec.jsj;
    kcb.cdbh := rec.cdbh;
    kcb.zt := '1';

    EXECUTE 'SELECT count(*) FROM t_xk_xkxx WHERE kch = ' || quote_literal(kcb.kch) || ' AND xh = ' || quote_literal(sno) || ' AND nd = ' || quote_literal(year) INTO record_count;
    IF record_count > 0 THEN
      kcb.zt := '2';
    END IF;

    IF kcb.zt = '1' THEN
      EXECUTE 'SELECT xf FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.kch = b.kch AND xf <= 0 AND gx = ' || quote_literal('>') || ' AND kch2 = ' || quote_literal(kcb.kch) || ' AND xh = ' || quote_literal(sno);
      IF FOUND THEN
        kcb.zt := '0';
      ELSE
        EXECUTE 'SELECT jhrs FROM t_xk_tj WHERE kcxh = ' || quote_literal(kcb.kcxh) || ' AND jhrs <= rs';
        IF FOUND THEN
          kcb.zt := '0';
        END IF;
      END IF;
    END IF;

    RETURN NEXT kcb;
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

CREATE OR REPLACE FUNCTION p_xk_xzkc(
    sno character,
    cno character,
    platform character,
    property character)
  RETURNS void AS
$BODY$DECLARE
  _paid INTEGER;
  _time VARCHAR;
  _year VARCHAR;
  _term VARCHAR;
  course RECORD;
  student RECORD;
BEGIN
  EXECUTE 'SELECT xh FROM t_xk_xsqf WHERE xh = $1' INTO _paid USING sno;
  IF FOUND THEN
    _paid := 0;
  ELSE
    _paid := 1;
  END IF;
  
  EXECUTE 'SELECT value FROM t_xt WHERE id = ' || quote_literal('XK_SJ') INTO _time;
  _year := substring(_time from 1 for 4);
  _term := substring(_time from 5 for 1);
  
  EXECUTE 'SELECT xm, nj, zsjj, zy FROM t_xs_zxs WHERE xh = $1' INTO student USING sno;
  
  EXECUTE 'SELECT a.jsgh, a.ksz, a.jsz, a.zc, a.ksj, a.jsj, b.kch, c.pt, c.xz, c.xl, c.kkxy, c.bz, d.zxf FROM t_pk_kb a LEFT JOIN t_pk_jxrw b ON a.nd = b.nd AND a.xq = b.xq AND a.kcxh = b.kcxh AND a.jsgh = b.jsgh LEFT JOIN t_pk_kczy c ON a.nd = c.nd AND a.xq = c.xq AND a.kcxh = c.kcxh AND c.nj = $1 AND c.zsjj = $2 AND c.zy = $3 LEFT JOIN t_jx_jxjh d ON d.zy = c.zy AND d.nj = c.nj AND d.zsjj = c.zsjj AND d.kch = b.kch WHERE a.nd = $4 AND a.xq = $5 AND a.kcxh = $6' INTO course USING student.nj, student.zsjj, student.zy, _year, _term, cno;

  EXECUTE 'INSERT INTO t_xk_xkxx(xh, xm, nd, xq, kcxh, kch, pt, xz, xl, jsgh, xf, sf, zg, cx, bz, sj, kkxy) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16,$17)' USING sno, student.xm, _year, _term, cno, course.kch, course.pt, course.xz, course.xl, course.jsgh, course.zxf, _paid, course.bz, '0', '0', CURRENT_TIMESTAMP, course.kkxy;
  EXECUTE 'UPDATE t_xk_tj SET rs = rs + 1 WHERE kcxh = $1' USING cno;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION p_xk_xzkc(character, character, character, character)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xk_xzkc(character, character, character, character) IS '选择课程';
