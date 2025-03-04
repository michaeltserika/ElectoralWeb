-- Création de la base de données
CREATE DATABASE election_app
    WITH TEMPLATE = template0
    ENCODING = 'UTF8'
    LOCALE_PROVIDER = libc
    LOCALE = 'French_Madagascar.1252';

-- Connexion à la base de données
\connect election_app

-- Configuration initiale
SET client_encoding = 'UTF8';
SET standard_conforming_strings = 'on';
SELECT pg_catalog.set_config('search_path', '', false);

-- Création des séquences
CREATE SEQUENCE public.candidats_id_candidat_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.comments_id_comment_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.elections_id_election_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.migrations_id_seq
    AS integer START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.notifications_id_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.utilisateurs_id_utilisateur_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

CREATE SEQUENCE public.votes_id_vote_seq
    START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

-- Création des tables
CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_pkey PRIMARY KEY (key)
);

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL,
    CONSTRAINT cache_locks_pkey PRIMARY KEY (key)
);

CREATE TABLE public.candidats (
    id_candidat bigint NOT NULL DEFAULT nextval('public.candidats_id_candidat_seq'),
    id_election bigint NOT NULL,
    nom character varying(100) NOT NULL,
    programme text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    image character varying(255),
    CONSTRAINT candidats_pkey PRIMARY KEY (id_candidat)
);

CREATE TABLE public.comments (
    id_comment bigint NOT NULL DEFAULT nextval('public.comments_id_comment_seq'),
    id_utilisateur bigint NOT NULL,
    id_candidat bigint NOT NULL,
    content text NOT NULL,
    parent_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT comments_pkey PRIMARY KEY (id_comment)
);

CREATE TABLE public.elections (
    id_election bigint NOT NULL DEFAULT nextval('public.elections_id_election_seq'),
    titre character varying(150) NOT NULL,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    type character varying(255) DEFAULT 'etablissement' NOT NULL,
    CONSTRAINT elections_pkey PRIMARY KEY (id_election),
    CONSTRAINT elections_type_check CHECK (type IN ('etablissement', 'communal', 'administratif'))
);

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL DEFAULT nextval('public.failed_jobs_id_seq'),
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT failed_jobs_pkey PRIMARY KEY (id),
    CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
);

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer,
    CONSTRAINT job_batches_pkey PRIMARY KEY (id)
);

CREATE TABLE public.jobs (
    id bigint NOT NULL DEFAULT nextval('public.jobs_id_seq'),
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL,
    CONSTRAINT jobs_pkey PRIMARY KEY (id)
);

CREATE TABLE public.migrations (
    id integer NOT NULL DEFAULT nextval('public.migrations_id_seq'),
    migration character varying(255) NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_pkey PRIMARY KEY (id)
);

CREATE TABLE public.notifications (
    id bigint NOT NULL DEFAULT nextval('public.notifications_id_seq'),
    id_utilisateur bigint NOT NULL,
    message character varying(255) NOT NULL,
    read boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notifications_pkey PRIMARY KEY (id)
);

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL,
    CONSTRAINT sessions_pkey PRIMARY KEY (id)
);

CREATE TABLE public.utilisateurs (
    id_utilisateur bigint NOT NULL DEFAULT nextval('public.utilisateurs_id_utilisateur_seq'),
    nom character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    mot_de_passe character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'VOTANT' NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    remember_token character varying(100),
    image character varying(255),
    ce_number character varying(255),
    cin_number character varying(255),
    date_of_birth date,
    CONSTRAINT utilisateurs_pkey PRIMARY KEY (id_utilisateur),
    CONSTRAINT utilisateurs_email_unique UNIQUE (email),
    CONSTRAINT utilisateurs_role_check CHECK (role IN ('ADMIN', 'VOTANT'))
);

CREATE TABLE public.votes (
    id_vote bigint NOT NULL DEFAULT nextval('public.votes_id_vote_seq'),
    id_utilisateur bigint NOT NULL,
    id_election bigint NOT NULL,
    id_candidat bigint NOT NULL,
    date_vote timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT votes_pkey PRIMARY KEY (id_vote),
    CONSTRAINT votes_id_utilisateur_id_election_unique UNIQUE (id_utilisateur, id_election)
);

-- Liaison des séquences aux colonnes
ALTER SEQUENCE public.candidats_id_candidat_seq OWNED BY public.candidats.id_candidat;
ALTER SEQUENCE public.comments_id_comment_seq OWNED BY public.comments.id_comment;
ALTER SEQUENCE public.elections_id_election_seq OWNED BY public.elections.id_election;
ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;
ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;
ALTER SEQUENCE public.utilisateurs_id_utilisateur_seq OWNED BY public.utilisateurs.id_utilisateur;
ALTER SEQUENCE public.votes_id_vote_seq OWNED BY public.votes.id_vote;

-- Création des index
CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);
CREATE INDEX sessions_last_activity_idx ON public.sessions USING btree (last_activity);

-- Ajout des contraintes de clés étrangères
ALTER TABLE public.candidats
    ADD CONSTRAINT candidats_id_election_foreign
    FOREIGN KEY (id_election) REFERENCES public.elections(id_election) ON DELETE CASCADE;

ALTER TABLE public.comments
    ADD CONSTRAINT comments_id_candidat_foreign
    FOREIGN KEY (id_candidat) REFERENCES public.candidats(id_candidat) ON DELETE CASCADE,
    ADD CONSTRAINT comments_id_utilisateur_foreign
    FOREIGN KEY (id_utilisateur) REFERENCES public.utilisateurs(id_utilisateur) ON DELETE CASCADE,
    ADD CONSTRAINT comments_parent_id_foreign
    FOREIGN KEY (parent_id) REFERENCES public.comments(id_comment) ON DELETE CASCADE;

ALTER TABLE public.notifications
    ADD CONSTRAINT notifications_id_utilisateur_foreign
    FOREIGN KEY (id_utilisateur) REFERENCES public.utilisateurs(id_utilisateur) ON DELETE CASCADE;

ALTER TABLE public.votes
    ADD CONSTRAINT votes_id_candidat_foreign
    FOREIGN KEY (id_candidat) REFERENCES public.candidats(id_candidat) ON DELETE CASCADE,
    ADD CONSTRAINT votes_id_election_foreign
    FOREIGN KEY (id_election) REFERENCES public.elections(id_election) ON DELETE CASCADE,
    ADD CONSTRAINT votes_id_utilisateur_foreign
    FOREIGN KEY (id_utilisateur) REFERENCES public.utilisateurs(id_utilisateur) ON DELETE CASCADE;

-- Initialisation des séquences (valeurs tirées du dump)
SELECT pg_catalog.setval('public.candidats_id_candidat_seq', 1, true);
SELECT pg_catalog.setval('public.comments_id_comment_seq', 1, true);
SELECT pg_catalog.setval('public.elections_id_election_seq', 3, true);
SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);
SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);
SELECT pg_catalog.setval('public.notifications_id_seq', 6, true);
SELECT pg_catalog.setval('public.utilisateurs_id_utilisateur_seq', 2, true);
SELECT pg_catalog.setval('public.votes_id_vote_seq', 1, false);

-- Insertion de données initiales (tables vides dans le dump fourni)
COPY public.cache (key, value, expiration) FROM stdin;
\.
COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.
COPY public.candidats (id_candidat, id_election, nom, programme, created_at, updated_at, image) FROM stdin;
\.
COPY public.comments (id_comment, id_utilisateur, id_candidat, content, parent_id, created_at, updated_at) FROM stdin;
\.
COPY public.elections (id_election, titre, date_debut, date_fin, created_at, updated_at, type) FROM stdin;
\.
COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.
COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.
COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.
COPY public.migrations (id, migration, batch) FROM stdin;
\.
COPY public.notifications (id, id_utilisateur, message, read, created_at, updated_at) FROM stdin;
\.
COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.
COPY public.utilisateurs (id_utilisateur, nom, email, mot_de_passe, role, created_at, updated_at, remember_token, image, ce_number, cin_number, date_of_birth) FROM stdin;
\.
COPY public.votes (id_vote, id_utilisateur, id_election, id_candidat, date_vote, created_at, updated_at) FROM stdin;
\.
