SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `setups` (
    `trackName` varchar(50) NOT NULL,
    `tirePressureLF` varchar(50) NOT NULL,
    `tirePressureRF` varchar(50) NOT NULL,
    `tirePressureLR` varchar(50) NOT NULL,
    `tirePressureRR` varchar(50) NOT NULL,
    `raceDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `setups` (`trackName`, `tirePressureLF`, `tirePressureRF`, `tirePressureLR`, `tirePressureRR`, `raceDate`) VALUES
('Flamboro Speedway', '14.5 PSI', '22.0 PSI', '14.5 PSI', '21.5 PSI', '2024-09-12'),
('Deleware Speedway', '15.0 PSI', '23.0 PSI', '14.5 PSI', '22.5 PSI', '2024-09-19'),

COMMIT;