/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     14/05/2022 14:10:36                          */
/*==============================================================*/




/*==============================================================*/
/* Table: DEVICE_SMART_KNOCK_LOCK                               */
/*==============================================================*/
create table DEVICE_SMART_KNOCK_LOCK
(
   ID_PERANGKAT         int not null  comment '' AUTO_INCREMENT,
   ID_MASTER            int  comment '',
   KAPASITAS_BATERAI    int  comment '',
   POLA_KUNCI           varchar(200)  comment '',
   KODE_PERANGKAT       varchar(20)  comment '',
   primary key (ID_PERANGKAT)
);

/*==============================================================*/
/* Table: MASTER                                                */
/*==============================================================*/
create table MASTER
(
   ID_MASTER            int not null  comment '' AUTO_INCREMENT,
   NAMA                 varchar(100)  comment '',
   EMAIL                varchar(50)  comment '',
   USERNAME             varchar(50)  comment '',
   PASSWORD             varchar(50)  comment '',
   primary key (ID_MASTER)
);

/*==============================================================*/
/* Table: RIWAYAT_BRANKAS                                       */
/*==============================================================*/
create table RIWAYAT_BRANKAS
(
   ID_RIWAYAT           int not null  comment '' AUTO_INCREMENT,
   ID_PERANGKAT         int  comment '',
   RIWAYAT_BRANKAS      datetime  comment '',
   STATUS_RIWAYAT       int  comment '',
   primary key (ID_RIWAYAT)
);

alter table DEVICE_SMART_KNOCK_LOCK add constraint FK_DEVICE_S_MEMILIKI1_MASTER foreign key (ID_MASTER)
      references MASTER (ID_MASTER) on delete restrict on update restrict;

alter table RIWAYAT_BRANKAS add constraint FK_RIWAYAT__MEMILIKI_DEVICE_S foreign key (ID_PERANGKAT)
      references DEVICE_SMART_KNOCK_LOCK (ID_PERANGKAT) on delete restrict on update restrict;

