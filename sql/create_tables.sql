

CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY, 
  nimi varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Esiintymispaikka(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL,
  osoite varchar(50) NOT NULL
);

CREATE TABLE Yhtye(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL,
  kuvaus varchar(400)
);

CREATE TABLE Keikka(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  paikka_id INTEGER REFERENCES Esiintymispaikka(id),
  yhtye_id INTEGER REFERENCES Yhtye(id),
  hinta DECIMAL,
  description varchar(400),
  paivamaara DATE
);


