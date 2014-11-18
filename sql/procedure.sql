选课课表：
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

CREATE OR REPLACE FUNCTION p_xk_hqkcb(sno character, year character, term character, season character, grade character, spno character, platform character, property character)
  RETURNS SETOF tp_xk_kcb AS
$BODY$DECLARE
  rec RECORD;
  qxkc RECORD;
  sksj RECORD;
  kcb tp_xk_kcb;
  query VARCHAR;
  rec_kch VARCHAR;
  record_count INTEGER;
  max_credit DECIMAL;
BEGIN
  query := 'SELECT kcxh, xl, bz, kkxy FROM t_xk_kxkcxx WHERE nd = ' || quote_literal(year) || ' AND xq = ' || quote_literal(term) || ' AND zsjj = ' || quote_literal(season) || ' AND nj = ' || quote_literal(grade) || ' AND zy = ' || quote_literal(spno) || ' AND pt = ' || quote_literal(platform) || ' AND xz = ' || quote_literal(property);

  FOR rec IN EXECUTE query LOOP
    kcb.kcxh := rec.kcxh;
    EXECUTE 'SELECT count(*) FROM t_xk_xkxx WHERE xh = ' || quote_literal(sno) || ' AND kcxh = ' || quote_literal(kcb.kcxh) || ' AND nd != ' || quote_literal(year) INTO record_count;
    
    IF record_count = 0 THEN      
      EXECUTE 'SELECT kch FROM t_pk_jxrw WHERE kcxh = ' || quote_literal(kcb.kcxh) || ' AND id = 1' INTO kcb.kch;

      query := 'SELECT kch FROM t_jx_kc_qxgx WHERE gx = ' || quote_literal('>') || ' AND kch2 = ' || quote_literal(kcb.kch);
      FOR qxkc IN EXECUTE query LOOP
        SELECT max(xf) INTO max_credit FROM t_cj_zxscj WHERE xh = quote_literal(sno) AND kch = quote_literal(qxkc.kch);

        IF max_credit <= 0 THEN
          kcb.zt := 0;
          EXIT;
        END IF;
      END LOOP;

      kcb.kcxh := rec.kcxh;
      kcb.zg := rec.bz;
      kcb.xl := rec.xl;
      kcb.kkxy := rec.kkxy;
      EXECUTE 'SELECT kcmc, kcywmc, xf, kh FROM t_jx_kc_xx WHERE kch = ' || quote_literal(kcb.kch) INTO kcb.kcmc, kcb.kcywmc, kcb.xf, kcb.kh;
      EXECUTE 'SELECT a.jsgh, b.xm as jsxm FROM t_pk_jxrw a JOIN t_pk_js b ON a.jsgh = b.jsgh WHERE nd = ' || quote_literal(year) || ' AND xq = ' || quote_literal(term) || ' AND kcxh = ' || quote_literal(kcb.kcxh) || ' AND id = 1' INTO kcb.jsgh, kcb.jsxm;
      
      query := 'SELECT rs, ksz, jsz, zc, ksj, jsj, cdbh, xqh, hb FROM t_pk_kb WHERE nd = ' || quote_literal(year) || ' AND xq = ' || quote_literal(term) || ' AND kcxh = ' || quote_literal(kcb.kcxh);
      FOR sksj IN EXECUTE query LOOP
        kcb.rs := sksj.rs;
        kcb.ksz := sksj.ksz;
        kcb.jsz := sksj.jsz;
        kcb.zc := sksj.zc;
        kcb.ksj := sksj.ksj;
        kcb.jsj := sksj.jsj;
        kcb.cdbh := sksj.cdbh;
        kcb.xqh := sksj.xqh;
        kcb.hb := sksj.hb;
      END LOOP;
    END IF;

    RETURN NEXT kcb;
  END LOOP;
END$BODY$
  LANGUAGE plpgsql IMMUTABLE;
ALTER FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character)
  OWNER TO jwxt;
COMMENT ON FUNCTION p_xk_hqkcb(character, character, character, character, character, character, character, character) IS '获取可选课程列表';

CREATE FUNCTION p_tj_xkjj() RETURNS table AS $$
BEGIN
END;
$$ LANGUAGE plpgsql;