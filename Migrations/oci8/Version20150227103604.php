<?php

namespace Claroline\CursusBundle\Migrations\oci8;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/02/27 10:36:06
 */
class Version20150227103604 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_cursusbundle_course (
                id NUMBER(10) NOT NULL, 
                workspace_model_id NUMBER(10) DEFAULT NULL NULL, 
                code VARCHAR2(255) NOT NULL, 
                title VARCHAR2(255) NOT NULL, 
                description CLOB DEFAULT NULL NULL, 
                public_registration NUMBER(1) NOT NULL, 
                public_unregistration NUMBER(1) NOT NULL, 
                registration_validation NUMBER(1) NOT NULL, 
                tutor_role_name VARCHAR2(255) DEFAULT NULL NULL, 
                learner_role_name VARCHAR2(255) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_COURSE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_COURSE ADD CONSTRAINT CLARO_CURSUSBUNDLE_COURSE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_COURSE_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_COURSE_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_COURSE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_COURSE_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_3359D34977153098 ON claro_cursusbundle_course (code)
        ");
        $this->addSql("
            CREATE INDEX IDX_3359D349EE7F5384 ON claro_cursusbundle_course (workspace_model_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_cursus (
                id NUMBER(10) NOT NULL, 
                course_id NUMBER(10) DEFAULT NULL NULL, 
                parent_id NUMBER(10) DEFAULT NULL NULL, 
                code VARCHAR2(255) DEFAULT NULL NULL, 
                title VARCHAR2(255) NOT NULL, 
                description CLOB DEFAULT NULL NULL, 
                blocking NUMBER(1) NOT NULL, 
                details CLOB DEFAULT NULL NULL, 
                cursus_order NUMBER(10) NOT NULL, 
                root NUMBER(10) DEFAULT NULL NULL, 
                lvl NUMBER(10) NOT NULL, 
                lft NUMBER(10) NOT NULL, 
                rgt NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_CURSUS' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_CURSUS ADD CONSTRAINT CLARO_CURSUSBUNDLE_CURSUS_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_CURSUS_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_CURSUS_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_CURSUS FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_CURSUS_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_27921C3377153098 ON claro_cursusbundle_cursus (code)
        ");
        $this->addSql("
            CREATE INDEX IDX_27921C33591CC992 ON claro_cursusbundle_cursus (course_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_27921C33727ACA70 ON claro_cursusbundle_cursus (parent_id)
        ");
        $this->addSql("
            COMMENT ON COLUMN claro_cursusbundle_cursus.details IS '(DC2Type:json_array)'
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_course_session_group (
                id NUMBER(10) NOT NULL, 
                group_id NUMBER(10) NOT NULL, 
                session_id NUMBER(10) NOT NULL, 
                registration_date TIMESTAMP(0) NOT NULL, 
                group_type NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP ADD CONSTRAINT CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_GROUP_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_F27287A4FE54D947 ON claro_cursusbundle_course_session_group (group_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_F27287A4613FECDF ON claro_cursusbundle_course_session_group (session_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX cursus_group_unique_course_session_group ON claro_cursusbundle_course_session_group (session_id, group_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_cursus_displayed_word (
                id NUMBER(10) NOT NULL, 
                word VARCHAR2(255) NOT NULL, 
                displayed_name VARCHAR2(255) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD ADD CONSTRAINT CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_DISPLAYED_WORD_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_14E7B098C3F17511 ON claro_cursusbundle_cursus_displayed_word (word)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_course_session (
                id NUMBER(10) NOT NULL, 
                course_id NUMBER(10) NOT NULL, 
                workspace_id NUMBER(10) DEFAULT NULL NULL, 
                learner_role_id NUMBER(10) DEFAULT NULL NULL, 
                tutor_role_id NUMBER(10) DEFAULT NULL NULL, 
                session_name VARCHAR2(255) NOT NULL, 
                session_status NUMBER(10) NOT NULL, 
                default_session NUMBER(1) NOT NULL, 
                creation_date TIMESTAMP(0) NOT NULL, 
                public_registration NUMBER(1) NOT NULL, 
                public_unregistration NUMBER(1) NOT NULL, 
                registration_validation NUMBER(1) NOT NULL, 
                start_date TIMESTAMP(0) DEFAULT NULL NULL, 
                end_date TIMESTAMP(0) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_COURSE_SESSION' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_COURSE_SESSION ADD CONSTRAINT CLARO_CURSUSBUNDLE_COURSE_SESSION_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_COURSE_SESSION_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_COURSE_SESSION_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_COURSE_SESSION FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_C5F56FDE591CC992 ON claro_cursusbundle_course_session (course_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_C5F56FDE82D40A1F ON claro_cursusbundle_course_session (workspace_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_C5F56FDEEF2297F5 ON claro_cursusbundle_course_session (learner_role_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_C5F56FDEBEFB2F13 ON claro_cursusbundle_course_session (tutor_role_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursus_sessions (
                coursesession_id NUMBER(10) NOT NULL, 
                cursus_id NUMBER(10) NOT NULL, 
                PRIMARY KEY(coursesession_id, cursus_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_5256A813AE020D6E ON claro_cursus_sessions (coursesession_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_5256A81340AEF4B9 ON claro_cursus_sessions (cursus_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_cursus_group (
                id NUMBER(10) NOT NULL, 
                group_id NUMBER(10) NOT NULL, 
                cursus_id NUMBER(10) NOT NULL, 
                registration_date TIMESTAMP(0) NOT NULL, 
                group_type NUMBER(10) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_CURSUS_GROUP' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_CURSUS_GROUP ADD CONSTRAINT CLARO_CURSUSBUNDLE_CURSUS_GROUP_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_CURSUS_GROUP_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_CURSUS_GROUP_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_CURSUS_GROUP FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_GROUP_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_GROUP_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_CURSUS_GROUP_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_GROUP_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_EA4DDE93FE54D947 ON claro_cursusbundle_cursus_group (group_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_EA4DDE9340AEF4B9 ON claro_cursusbundle_cursus_group (cursus_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX cursus_group_unique_cursus_group ON claro_cursusbundle_cursus_group (cursus_id, group_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_course_session_user (
                id NUMBER(10) NOT NULL, 
                user_id NUMBER(10) NOT NULL, 
                session_id NUMBER(10) NOT NULL, 
                registration_date TIMESTAMP(0) NOT NULL, 
                user_type NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_USER' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_COURSE_SESSION_USER ADD CONSTRAINT CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_COURSE_SESSION_USER FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_USER_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_80B4120FA76ED395 ON claro_cursusbundle_course_session_user (user_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_80B4120F613FECDF ON claro_cursusbundle_course_session_user (session_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX cursus_user_unique_course_session_user ON claro_cursusbundle_course_session_user (session_id, user_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_course_session_registration_queue (
                id NUMBER(10) NOT NULL, 
                user_id NUMBER(10) NOT NULL, 
                session_id NUMBER(10) NOT NULL, 
                application_date TIMESTAMP(0) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE ADD CONSTRAINT CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_COURSE_SESSION_REGISTRATION_QUEUE_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_334FC296A76ED395 ON claro_cursusbundle_course_session_registration_queue (user_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_334FC296613FECDF ON claro_cursusbundle_course_session_registration_queue (session_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX session_queue_unique_session_user ON claro_cursusbundle_course_session_registration_queue (session_id, user_id)
        ");
        $this->addSql("
            CREATE TABLE claro_cursusbundle_cursus_user (
                id NUMBER(10) NOT NULL, 
                user_id NUMBER(10) NOT NULL, 
                cursus_id NUMBER(10) NOT NULL, 
                registration_date TIMESTAMP(0) NOT NULL, 
                user_type NUMBER(10) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_CURSUSBUNDLE_CURSUS_USER' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_CURSUSBUNDLE_CURSUS_USER ADD CONSTRAINT CLARO_CURSUSBUNDLE_CURSUS_USER_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_CURSUSBUNDLE_CURSUS_USER_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_CURSUSBUNDLE_CURSUS_USER_AI_PK BEFORE INSERT ON CLARO_CURSUSBUNDLE_CURSUS_USER FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_USER_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_USER_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_CURSUSBUNDLE_CURSUS_USER_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_CURSUSBUNDLE_CURSUS_USER_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_8AA52D8A76ED395 ON claro_cursusbundle_cursus_user (user_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_8AA52D840AEF4B9 ON claro_cursusbundle_cursus_user (cursus_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX cursus_user_unique_cursus_user ON claro_cursusbundle_cursus_user (cursus_id, user_id)
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course 
            ADD CONSTRAINT FK_3359D349EE7F5384 FOREIGN KEY (workspace_model_id) 
            REFERENCES claro_workspace_model (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus 
            ADD CONSTRAINT FK_27921C33591CC992 FOREIGN KEY (course_id) 
            REFERENCES claro_cursusbundle_course (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus 
            ADD CONSTRAINT FK_27921C33727ACA70 FOREIGN KEY (parent_id) 
            REFERENCES claro_cursusbundle_cursus (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_group 
            ADD CONSTRAINT FK_F27287A4FE54D947 FOREIGN KEY (group_id) 
            REFERENCES claro_group (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_group 
            ADD CONSTRAINT FK_F27287A4613FECDF FOREIGN KEY (session_id) 
            REFERENCES claro_cursusbundle_course_session (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session 
            ADD CONSTRAINT FK_C5F56FDE591CC992 FOREIGN KEY (course_id) 
            REFERENCES claro_cursusbundle_course (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session 
            ADD CONSTRAINT FK_C5F56FDE82D40A1F FOREIGN KEY (workspace_id) 
            REFERENCES claro_workspace (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session 
            ADD CONSTRAINT FK_C5F56FDEEF2297F5 FOREIGN KEY (learner_role_id) 
            REFERENCES claro_role (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session 
            ADD CONSTRAINT FK_C5F56FDEBEFB2F13 FOREIGN KEY (tutor_role_id) 
            REFERENCES claro_role (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_cursus_sessions 
            ADD CONSTRAINT FK_5256A813AE020D6E FOREIGN KEY (coursesession_id) 
            REFERENCES claro_cursusbundle_course_session (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursus_sessions 
            ADD CONSTRAINT FK_5256A81340AEF4B9 FOREIGN KEY (cursus_id) 
            REFERENCES claro_cursusbundle_cursus (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_group 
            ADD CONSTRAINT FK_EA4DDE93FE54D947 FOREIGN KEY (group_id) 
            REFERENCES claro_group (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_group 
            ADD CONSTRAINT FK_EA4DDE9340AEF4B9 FOREIGN KEY (cursus_id) 
            REFERENCES claro_cursusbundle_cursus (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_user 
            ADD CONSTRAINT FK_80B4120FA76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_user 
            ADD CONSTRAINT FK_80B4120F613FECDF FOREIGN KEY (session_id) 
            REFERENCES claro_cursusbundle_course_session (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_registration_queue 
            ADD CONSTRAINT FK_334FC296A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_registration_queue 
            ADD CONSTRAINT FK_334FC296613FECDF FOREIGN KEY (session_id) 
            REFERENCES claro_cursusbundle_course_session (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_user 
            ADD CONSTRAINT FK_8AA52D8A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_user 
            ADD CONSTRAINT FK_8AA52D840AEF4B9 FOREIGN KEY (cursus_id) 
            REFERENCES claro_cursusbundle_cursus (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus 
            DROP CONSTRAINT FK_27921C33591CC992
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session 
            DROP CONSTRAINT FK_C5F56FDE591CC992
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus 
            DROP CONSTRAINT FK_27921C33727ACA70
        ");
        $this->addSql("
            ALTER TABLE claro_cursus_sessions 
            DROP CONSTRAINT FK_5256A81340AEF4B9
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_group 
            DROP CONSTRAINT FK_EA4DDE9340AEF4B9
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_cursus_user 
            DROP CONSTRAINT FK_8AA52D840AEF4B9
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_group 
            DROP CONSTRAINT FK_F27287A4613FECDF
        ");
        $this->addSql("
            ALTER TABLE claro_cursus_sessions 
            DROP CONSTRAINT FK_5256A813AE020D6E
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_user 
            DROP CONSTRAINT FK_80B4120F613FECDF
        ");
        $this->addSql("
            ALTER TABLE claro_cursusbundle_course_session_registration_queue 
            DROP CONSTRAINT FK_334FC296613FECDF
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_course
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_cursus
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_course_session_group
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_cursus_displayed_word
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_course_session
        ");
        $this->addSql("
            DROP TABLE claro_cursus_sessions
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_cursus_group
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_course_session_user
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_course_session_registration_queue
        ");
        $this->addSql("
            DROP TABLE claro_cursusbundle_cursus_user
        ");
    }
}