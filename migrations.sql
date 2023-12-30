-- Creazione della tabella 'countries'
CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Creazione della tabella 'travels'
CREATE TABLE IF NOT EXISTS travels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(255) NOT NULL,
    seats_available INT NOT NULL
);