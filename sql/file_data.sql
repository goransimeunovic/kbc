SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `file_data` (
                             `id` int(11) NOT NULL,
                             `dir_path` varchar(256) NOT NULL,
                             `name` varchar(256) NOT NULL,
                             `size` int(11) NOT NULL,
                             `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `file_data`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `file_data`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;
