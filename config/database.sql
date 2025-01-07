-- Table for CLIENT
CREATE TABLE IF NOT EXISTS CLIENT (
  id_client VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  nom VARCHAR2(255) NOT NULL,
  prenom VARCHAR2(255) NOT NULL,
  adresse VARCHAR2(255),
  telephone VARCHAR2(255) NOT NULL UNIQUE,
  email VARCHAR2(255) NOT NULL UNIQUE,
  hashed_password VARCHAR2(255) NOT NULL,
  passport_id VARCHAR2(255) UNIQUE,
  cin_id VARCHAR2(255) UNIQUE,
  is_admin BOOLEAN DEFAULT FALSE,
  CONSTRAINT pk_client PRIMARY KEY (id_client)
);


-- Table for RESERVATION
CREATE TABLE IF NOT EXISTS RESERVATION (
  id_reservation VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  statut VARCHAR2(255) CHECK (statut IN ('confirmée', 'annulée', 'en attente')) NOT NULL,
  id_client VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_reservation PRIMARY KEY (id_reservation),
  CONSTRAINT fk_reservation_client FOREIGN KEY (id_client) REFERENCES CLIENT (id_client) ON DELETE CASCADE
);

-- Table for PAIEMENT
CREATE TABLE IF NOT EXISTS PAIEMENT (
  id_paiement VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  montant NUMBER(10, 2),
  mode_paiement VARCHAR2(255) CHECK (mode_paiement IN ('cash', 'card', 'bank transfer')) NOT NULL,
  paiement_date DATE,
  id_reservation VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_paiement PRIMARY KEY (id_paiement),
  CONSTRAINT fk_paiement_reservation FOREIGN KEY (id_reservation) REFERENCES RESERVATION (id_reservation) ON DELETE CASCADE
);


-- Table for CHAMBRE
CREATE TABLE IF NOT EXISTS CHAMBRE (
  id_chambre VARCHAR2(255) NOT NULL,
  type VARCHAR2(255) NOT NULL,
  tarif NUMBER(10, 2) NOT NULL,
  etat VARCHAR2(255) CHECK (etat IN ('disponible', 'occupée', 'en maintenance')) NOT NULL,
  CONSTRAINT pk_chambre PRIMARY KEY (id_chambre)
);

-- Table for SERVICE_SUPPLEMENTAIRE
CREATE TABLE IF NOT EXISTS SERVICE_SUPPLEMENTAIRE (
  id_service VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  nom VARCHAR2(255) NOT NULL,
  tarif NUMBER(10, 2) NOT NULL,
  description VARCHAR2(255),
  id_reservation VARCHAR2(255),
  CONSTRAINT pk_service_supp PRIMARY KEY (id_service),
  CONSTRAINT fk_service_supp_reserv FOREIGN KEY (id_reservation) REFERENCES RESERVATION (id_reservation) ON DELETE CASCADE
);

-- Table for FACTURE
CREATE TABLE IF NOT EXISTS FACTURE (
  id_facture VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  date_emission DATE,
  montant NUMBER(10, 2),
  id_reservation VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_facture PRIMARY KEY (id_facture),
  CONSTRAINT fk_facture_reserv FOREIGN KEY (id_reservation) REFERENCES RESERVATION (id_reservation) ON DELETE CASCADE
);

-- Table for CONCERNE
CREATE TABLE IF NOT EXISTS CONCERNE (
  id_reservation VARCHAR2(255) NOT NULL,
  id_chambre VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_concerne PRIMARY KEY (id_reservation, id_chambre),
  CONSTRAINT fk_concerne_reserv FOREIGN KEY (id_reservation) REFERENCES RESERVATION (id_reservation) ON DELETE CASCADE,
  CONSTRAINT fk_concerne_chambre FOREIGN KEY (id_chambre) REFERENCES CHAMBRE (id_chambre) ON DELETE CASCADE
);



-- Table for ASSOCIER_SERVICE_FACTURE
CREATE TABLE IF NOT EXISTS ASSOCIER_SERVICE_FACTURE (
  id_service VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  id_facture VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_assoc_service_fact PRIMARY KEY (id_service, id_facture),
  CONSTRAINT fk_assoc_service_fact_fact FOREIGN KEY (id_facture) REFERENCES FACTURE (id_facture) ON DELETE CASCADE,
  CONSTRAINT fk_assoc_service_fact_serv FOREIGN KEY (id_service) REFERENCES SERVICE_SUPPLEMENTAIRE (id_service) ON DELETE CASCADE
);

-- Table for ASSOCIER_SERVICE_RESERVATION
CREATE TABLE IF NOT EXISTS ASSOCIER_SERVICE_RESERVATION (
  id_service VARCHAR2(255) DEFAULT SYS_GUID() NOT NULL,
  id_reservation VARCHAR2(255) NOT NULL,
  CONSTRAINT pk_assoc_service_reserv PRIMARY KEY (id_service, id_reservation),
  CONSTRAINT fk_assoc_service_reserv_reserv FOREIGN KEY (id_reservation) REFERENCES RESERVATION (id_reservation) ON DELETE CASCADE,
  CONSTRAINT fk_assoc_service_reserv_serv FOREIGN KEY (id_service) REFERENCES SERVICE_SUPPLEMENTAIRE (id_service) ON DELETE CASCADE
);
