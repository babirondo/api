--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5beta2
-- Dumped by pg_dump version 9.5beta2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: JOGADOR; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "JOGADOR" (
    "ID_JOGADOR" integer NOT NULL,
    "NOME" text,
    "EMAIL" text,
    "SENHA" text,
    "NUM" text,
    "PESO" text,
    "ALTURA" text
);


ALTER TABLE "JOGADOR" OWNER TO postgres;

--
-- Name: JOGADOR_ID_JOGADOR_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "JOGADOR_ID_JOGADOR_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "JOGADOR_ID_JOGADOR_seq" OWNER TO postgres;

--
-- Name: JOGADOR_ID_JOGADOR_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "JOGADOR_ID_JOGADOR_seq" OWNED BY "JOGADOR"."ID_JOGADOR";


--
-- Name: JOGADOR_POSICOES; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "JOGADOR_POSICOES" (
    "ID_JOGADOR" integer,
    "ID_POSICAO_JOGADOR" integer NOT NULL,
    "ID_POSICAO" integer
);


ALTER TABLE "JOGADOR_POSICOES" OWNER TO postgres;

--
-- Name: JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq" OWNER TO postgres;

--
-- Name: JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq" OWNED BY "JOGADOR_POSICOES"."ID_POSICAO_JOGADOR";


--
-- Name: POSICOES; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "POSICOES" (
    "ID_POSICAO" integer NOT NULL,
    "POSICAO" text
);


ALTER TABLE "POSICOES" OWNER TO postgres;

--
-- Name: POSICOES_ID_POSICAO_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "POSICOES_ID_POSICAO_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "POSICOES_ID_POSICAO_seq" OWNER TO postgres;

--
-- Name: POSICOES_ID_POSICAO_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "POSICOES_ID_POSICAO_seq" OWNED BY "POSICOES"."ID_POSICAO";


--
-- Name: TIMES; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "TIMES" (
    "ID_TIME" integer NOT NULL,
    "TIME" text
);


ALTER TABLE "TIMES" OWNER TO postgres;

--
-- Name: TIMES_ID_TIME_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "TIMES_ID_TIME_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "TIMES_ID_TIME_seq" OWNER TO postgres;

--
-- Name: TIMES_ID_TIME_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "TIMES_ID_TIME_seq" OWNED BY "TIMES"."ID_TIME";


--
-- Name: TIME_JOGADORES; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "TIME_JOGADORES" (
    "ID_TIME_JOGADOR" integer NOT NULL,
    "ID_TIME" integer,
    "ID_JOGADOR" integer,
    entrada date,
    saida date
);


ALTER TABLE "TIME_JOGADORES" OWNER TO postgres;

--
-- Name: TIME_JOGADORES_ID_TIME_JOGADOR_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "TIME_JOGADORES_ID_TIME_JOGADOR_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "TIME_JOGADORES_ID_TIME_JOGADOR_seq" OWNER TO postgres;

--
-- Name: TIME_JOGADORES_ID_TIME_JOGADOR_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "TIME_JOGADORES_ID_TIME_JOGADOR_seq" OWNED BY "TIME_JOGADORES"."ID_TIME_JOGADOR";


--
-- Name: TIME_JOGADOR_POSICOES; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "TIME_JOGADOR_POSICOES" (
    "ID_TIME_JOGADOR_POSICAO" integer NOT NULL,
    "ID_TIME_JOGADOR" integer,
    "ID_POSICAO" integer
);


ALTER TABLE "TIME_JOGADOR_POSICOES" OWNER TO postgres;

--
-- Name: TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq" OWNER TO postgres;

--
-- Name: TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq" OWNED BY "TIME_JOGADOR_POSICOES"."ID_TIME_JOGADOR_POSICAO";


--
-- Name: ID_JOGADOR; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "JOGADOR" ALTER COLUMN "ID_JOGADOR" SET DEFAULT nextval('"JOGADOR_ID_JOGADOR_seq"'::regclass);


--
-- Name: ID_POSICAO_JOGADOR; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "JOGADOR_POSICOES" ALTER COLUMN "ID_POSICAO_JOGADOR" SET DEFAULT nextval('"JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq"'::regclass);


--
-- Name: ID_POSICAO; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "POSICOES" ALTER COLUMN "ID_POSICAO" SET DEFAULT nextval('"POSICOES_ID_POSICAO_seq"'::regclass);


--
-- Name: ID_TIME; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "TIMES" ALTER COLUMN "ID_TIME" SET DEFAULT nextval('"TIMES_ID_TIME_seq"'::regclass);


--
-- Name: ID_TIME_JOGADOR; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "TIME_JOGADORES" ALTER COLUMN "ID_TIME_JOGADOR" SET DEFAULT nextval('"TIME_JOGADORES_ID_TIME_JOGADOR_seq"'::regclass);


--
-- Name: ID_TIME_JOGADOR_POSICAO; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "TIME_JOGADOR_POSICOES" ALTER COLUMN "ID_TIME_JOGADOR_POSICAO" SET DEFAULT nextval('"TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq"'::regclass);


--
-- Data for Name: JOGADOR; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "JOGADOR" ("ID_JOGADOR", "NOME", "EMAIL", "SENHA", "NUM", "PESO", "ALTURA") FROM stdin;
2	Bruno Siqueira	babirondo@gmail.com	senha	13	99	1,78
\.


--
-- Name: JOGADOR_ID_JOGADOR_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"JOGADOR_ID_JOGADOR_seq"', 2, true);


--
-- Data for Name: JOGADOR_POSICOES; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "JOGADOR_POSICOES" ("ID_JOGADOR", "ID_POSICAO_JOGADOR", "ID_POSICAO") FROM stdin;
\.


--
-- Name: JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"JOGADOR_POSICOES_ID_POSICAO_JOGADOR_seq"', 103, true);


--
-- Data for Name: POSICOES; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "POSICOES" ("ID_POSICAO", "POSICAO") FROM stdin;
1	SNAKE
2	SNAKE CORNER
3	BACK CENTER
4	DORITOS
5	DORITOS CORNER
6	COACH
\.


--
-- Name: POSICOES_ID_POSICAO_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"POSICOES_ID_POSICAO_seq"', 6, true);


--
-- Data for Name: TIMES; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TIMES" ("ID_TIME", "TIME") FROM stdin;
3	Mega Play Paintball Team
\.


--
-- Name: TIMES_ID_TIME_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TIMES_ID_TIME_seq"', 3, true);


--
-- Data for Name: TIME_JOGADORES; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TIME_JOGADORES" ("ID_TIME_JOGADOR", "ID_TIME", "ID_JOGADOR", entrada, saida) FROM stdin;
9	3	2	2015-12-13	\N
\.


--
-- Name: TIME_JOGADORES_ID_TIME_JOGADOR_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TIME_JOGADORES_ID_TIME_JOGADOR_seq"', 9, true);


--
-- Data for Name: TIME_JOGADOR_POSICOES; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TIME_JOGADOR_POSICOES" ("ID_TIME_JOGADOR_POSICAO", "ID_TIME_JOGADOR", "ID_POSICAO") FROM stdin;
\.


--
-- Name: TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TIME_JOGADOR_POSICOES_ID_TIME_JOGADOR_POSICAO_seq"', 58, true);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

