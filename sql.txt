CREATE DATABASE doctor;
USE doctor;

CREATE TABLE users( 
   uid int AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20) NOT NULL, 
  email VARCHAR(100) NOT NULL,
  password CHAR(128) NOT NULL,
  is_doctor Boolean default false,
  is_active Boolean default false,
  hospital_name VARCHAR(100)
);

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `is_doctor`, `is_active`, `hospital_name`) VALUES
(1, 'Doctor1', 'doc@gmail.com', '$2y$10$MwH65/sJD8muYtTJUqzcFOtPOmP4092QE4LcDNCCo54JJyG8H1p8u', 1, 0, 'Kansas Hospital'),
(2, 'Suresh', 'j@gmail.com', '$2y$10$MwH65/sJD8muYtTJUqzcFOtPOmP4092QE4LcDNCCo54JJyG8H1p8u', 1, 0, 'Kansas Clinic '),
(4, 'Naga', 'ss@gmail.com', '$2y$10$w319.Ipz0g9DAyyF1sSTVOFFmi4MSSvcBB.v2kOvTzd9Bo0vN37pK', 0, 1, ''),
(5, 'Doctor2', 'k@gmail.com', '$2y$10$Tdu5tBdg89J.7GkaCZCyHu40xg8YGlg/Yl0NInQzQVWMJW.mjoNby', 1, 0, 'Minorah Medical Center'),
(6, 'DROP TABLE users;', 'js@gmail.com', '$2y$10$HeMGm6U1tvrI3T/sUAK..emmIBxs8IWIBd/h3niGOEpfQ21QhEz/a', 0, 0, ''),
(7, 'e;DROP TABLE users;', 'kk@gmail.com', '$2y$10$IIitQP6hJuaxs1/p7gS26er0FAX0/tXjVrW.dTFp5P5twQg6Vv6UC', 0, 0, '');


-- password is password and same for all users 

CREATE TABLE IF NOT EXISTS appointments(
  appointment_id int AUTO_INCREMENT PRIMARY KEY,
  doctor_uid int NOT NULL,
  patient_uid int NOT NULL,
  time_appointment VARCHAR(20) NOT NULL,
  date_appointment VARCHAR(20) NOT NULL
);

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `doctor_uid`, `patient_uid`, `time_appointment`, `date_appointment`) VALUES
(1, 1, 4, '6.30', '2022-11-29'),
(3, 1, 4, '6.00', '2022-11-29'),
(8, 1, 4, '7.00', '2022-11-29'),
(9, 1, 4, '7.30', '2022-11-29'),
(10, 5, 4, '6.00', '2022-11-29'),
(11, 1, 4, '8.00', '2022-11-29'),
(12, 2, 4, '7.00', '2022-11-30'),
(13, 1, 4, '9.00', '2022-11-30');


CREATE TABLE IF NOT EXISTS appointmentchat(
  appointment_id int,
  sendby int NOT NULL,
  message varchar(255) NOT NULL,
  time_of_message VARCHAR(20) NOT NULL,
  date_of_message VARCHAR(20) NOT NULL
);


INSERT INTO `appointmentchat` (`appointment_id`, `sendby`, `message`, `time_of_message`, `date_of_message`) VALUES
(1, 4, 'hi', '05:51:19', '2022-11-30'),
(1, 1, 'hello patient', '05:51:28', '2022-11-30'),
(9, 4, 'Hello', '05:52:00', '2022-11-30'),
(9, 1, 'hello patient', '05:52:08', '2022-11-30'),
(13, 1, 'Hello Patient', '10:21:08', '2022-11-30'),
(13, 4, 'hello doctor', '10:21:31', '2022-11-30');