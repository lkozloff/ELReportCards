-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 01:54 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `el_reportcards`
--
CREATE DATABASE `el_reportcards` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `el_reportcards`;

-- --------------------------------------------------------

--
-- Table structure for table `el_comments`
--

CREATE TABLE IF NOT EXISTS `el_comments` (
  `template_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `template_id` (`template_id`,`student_id`,`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `el_grades`
--

CREATE TABLE IF NOT EXISTS `el_grades` (
  `template_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `term` varchar(2) NOT NULL,
  `type` varchar(1) NOT NULL,
  `value` varchar(2) NOT NULL,
  UNIQUE KEY `template_id` (`template_id`,`topic_id`,`student_id`,`term`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `template_fields`
--

CREATE TABLE IF NOT EXISTS `template_fields` (
  `template_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `text_en` varchar(256) NOT NULL,
  `text_kh` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_graded` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_fields`
--

INSERT INTO `template_fields` (`template_id`, `topic_id`, `text_en`, `text_kh`, `is_graded`) VALUES
(1, 0, 'English Language Arts', 'អក្សរសាស្ត្រអង់គ្លេស', 0),
(1, 1, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(1, 2, 'Reading', 'ការអាន', 1),
(1, 3, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(1, 4, 'Khmer Language Arts', 'អក្សរសាស្ត្រខ្មែរ', 0),
(1, 5, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(1, 6, 'Reading', 'ការអាន', 1),
(1, 7, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(1, 8, 'Mathematics', 'គណិតវិទ្យា', 0),
(1, 9, 'Numbers', 'លេខ', 1),
(1, 10, 'Shape, Space and Measure', 'រូបរាង,ចន្លោះ និងរង្វាស់ប្រវែង', 1),
(1, 11, 'Data Handling', 'ការប្រើទិន្នន័យ', 1),
(1, 12, 'Problem Solving', 'ការដោះស្រាយលំហាត់បញ្ហា', 1),
(1, 13, '', '', 0),
(1, 14, 'Topic (Science, Social Studies, Humanities, Art)', 'ប្រធានបទ (វិទ្យាសាស្ត្រ,សិក្សាសង្គម,មនុស្សសាស្ត្រ,សិល្បៈ)', 1),
(1, 15, 'Performing Arts', 'ស្នាដៃសិល្បៈ', 1),
(1, 16, 'Physical Education', 'ការសិក្សាពីរូបរាងកាយ', 1),
(1, 17, 'Study and Learning Skills', 'ជំនាញសិក្សានិងការរៀនសូត្រ', 0),
(1, 18, 'Works independently', 'ធ្វើកិច្ចការបានដោយខ្លួនឯង', 1),
(1, 19, 'Plays well in groups', 'កិច្ចការល្អជាក្រុម', 1),
(1, 20, 'Plays cooperatively with others', 'ការសហគ្នាក្នុងការលេងជាមួយអ្នកដ៏ទៃ', 1),
(1, 21, 'Follows directions', 'ស្តាប់ការណែនាំបង្រៀន', 1),
(1, 22, 'Organizes and looks after belongings', 'ការរៀបចំនិងថែរក្សារបស់​ផ្ទាល់ខ្លួន', 1),
(1, 23, 'Perseveres in problem solving', 'ព្យាយាមក្នុងការដោះស្រាយបញ្ហា', 1),
(1, 24, 'Makes good use of time', 'ប្រើប្រាស់ពេលវេលាបានល្អ', 1),
(1, 25, 'Seeks help when needed', 'ស្វែងរកជំនួយនៅពេលត្រូវការ', 1),
(1, 26, 'Completes classwork', 'បញ្ចប់កិច្ចការក្នុងថ្នាក់', 1),
(1, 27, 'Works neatly and carefully', 'កិច្ចការស្អាតនិងប្រុងប្រយ័ត្ន', 1),
(2, 0, 'Language Development', 'ការអភិវឌ្ឈន៍ភាសាសាស្ត្រ ', 0),
(2, 1, 'Knows names of things in topic time in English', 'ដឹងពីឈ្មោះវត្ថុក្នុងប្រធានបទជាភាសាអង់គ្លេស', 1),
(2, 2, 'Knows names of things in topic in Khmer', 'ដឹងពីឈ្មោះវត្ថុក្នុងប្រធានបទជាភាសាខ្មែរ', 1),
(2, 3, 'Follows Simple instructions', 'ធ្វើតាមការណែនាំបង្រៀនសាមញ្ញ', 1),
(2, 4, 'Recognizes own name', 'ស្គាល់ឈ្មោះរបស់ខ្លួន', 1),
(2, 5, 'Volunteers responses to discussion', 'ស្ម័គ្រចិត្តឆ្លើយតបក្នុងការពិភាគ្សា', 1),
(2, 6, 'Listens to stories', 'ស្តាប់ការនិទានរឿង', 1),
(2, 7, 'Actively listens to adults and classmates', 'សកម្មភាពស្តាប់អ្នកវ័យជំទង់និង​មិត្តរួមថ្នាក់', 1),
(2, 8, 'Holds books correctly and generally takes an interest in books', 'កាន់សៀវភៅបានត្រឹមត្រូវនិងមានចំណាប់អារម្មណ៍មួយលើសៀវភៅ', 1),
(2, 9, 'Holds a pencil correctly', 'កាន់ខ្មៅដៃបានត្រឹមត្រូវ', 1),
(2, 10, 'Can complete puzzles', 'អាចបញ្ចប់ល្បែងដាក់បំពេញ', 1),
(2, 11, 'Mathematical Development', 'ការអភិវឌ្ឈន៍ផ្នែកគណិតវិទ្យា', 0),
(2, 12, 'Recognizes basic shapes', 'ស្គាល់រូបរាងជាមូលដ្ឋាន', 1),
(2, 13, 'Counts reliably in English (1-20)', 'អាចរាប់លេខជាភាសាអង់គ្លេស(ពីលេខ១ដល់លេខ២០)', 1),
(2, 14, 'Counts reliably in Khmer (1-20)', 'អាចរាប់លេខជាភាសាខ្មែរ(ពីលេខ១ដល់លេខ២០)', 1),
(2, 15, 'Recognizes numbers', 'ស្គាល់ពីចំនួន', 1),
(2, 16, 'Is able to sort objects', 'អាចចាត់ថ្នាក់វត្ថុ', 1),
(2, 17, 'Sorts according to size', 'អាចចាត់ថ្នាក់ទៅតាមទំហំ', 1),
(2, 18, 'Joins in number rhymes, songs and games', 'ចូលរួមរាប់លេខទៅតាមពាក្យជួន ចំរៀង និងល្បែង', 1),
(2, 19, 'Knowledge and understanding of the world', 'ចំណេះដឹងនិងការយល់ពីពិភពលោក', 0),
(2, 20, 'Knows the names for the members of the family', 'ដឹងឈ្មោះរបស់សមាជិកក្នុងគ្រួសារ', 1),
(2, 21, 'Can name the five senses', 'អាចប្រាប់ឈ្មោះញាណទាំង៥', 1),
(2, 22, 'Can identify features of the different seasons', 'អាចសំគាល់លក្ខណៈរបស់រដូវផ្សេងៗគ្នា', 1),
(2, 23, 'Identifies different transport', 'សំគាល់មធ្យោបាយដឹកជញ្ជូនផ្សេងៗគ្នា', 1),
(2, 24, 'Knows the different features of birds and fish', 'ដឹងពីលក្ខណៈផ្សេងៗគ្នារបស់សត្វបក្សីនិងសត្វត្រី', 1),
(2, 25, 'Physical Development', 'ការអភិវឌ្ឈន៍ខាងរូបរាងកាយ', 0),
(2, 26, 'Has well developed fine motor skills', 'មានការអភិវឌ្ឈន៍ល្អលើជំនាញប្រើដៃ', 1),
(2, 27, 'Enjoys physical activities', 'ចូលចិត្តសកម្មភាពធ្វើចលនារូបរាងកាយ', 1),
(2, 28, 'Has well developed gross motor skills', 'មានការអភិវឌ្ឈន៍លើជំនាញរូបរាយកាយ', 1),
(2, 29, 'Creative Development', 'ការអភិវឌ្ឍន៍ការឆ្នៃប្រឌិត', 0),
(2, 30, 'Can identify basic colours', 'អាចសំគាល់ពណ៌មូលដ្ឋាន', 1),
(2, 31, 'Joins in with music and movement activities', 'ចូលរួមជាមួយតន្ត្រីនិងសកម្មភាពចលនា', 1),
(2, 32, 'Likes to do art and craft activities', 'ចូលចិត្តធ្វើសកម្មភាពសិល្បៈនិងសិល្បៈរូបភាព', 1),
(2, 33, 'Life Skills / Personal Development', 'បទពិសោធន៍ជីវិតនិងការអភិវឌ្ឈន៍ផ្ទាល់ខ្លួន', 0),
(2, 34, 'Listens to my teacher', 'ស្តាប់គ្រូរបស់ខ្លួន', 1),
(2, 35, 'Can work independently and concentrate until my tasks are finished', 'ធ្វើកិច្ចការបានដោយខ្លួនឯងនិងផ្តោតការយកចិត្តទុកដាក់រហូតដល់កិច្ចការរបស់ខ្លួនបានបញ្ចប់', 1),
(2, 36, 'Can use my own ideas', 'អាចប្រើគំនិតផ្ទាល់របស់ខ្លួន', 1),
(2, 37, 'Understands and follow rules and routines', 'យល់និងធ្វើតាមច្បាប់និងកាលវិភាគ', 1),
(2, 38, 'Can share and take turns', 'អាចចែករំលែកនិងដឹងពីវេន', 1),
(2, 39, 'Tries new tasks', 'សាកល្បងធ្វើកិច្ចការថ្មី', 1),
(3, 0, 'Language Development', 'ការអភិវឌ្ឈន៍ភាសាសាស្ត្រ ', 0),
(3, 1, 'Knows names of things in topic time in English', 'ដឹងពីឈ្មោះវត្ថុក្នុងប្រធានបទជាភាសាអង់គ្លេស', 1),
(3, 2, 'Knows names of things in topic in Khmer', 'ដឹងពីឈ្មោះវត្ថុក្នុងប្រធានបទជាភាសាខ្មែរ', 1),
(3, 3, 'Follows Simple instructions', 'ធ្វើតាមការណែនាំបង្រៀនសាមញ្ញ', 1),
(3, 4, 'Recognizes own name', 'ស្គាល់ឈ្មោះរបស់ខ្លួន', 1),
(3, 5, 'Volunteers responses to discussion', 'ស្ម័គ្រចិត្តឆ្លើយតបក្នុងការពិភាគ្សា', 1),
(3, 6, 'Listens to stories', 'ស្តាប់ការនិទានរឿង', 1),
(3, 7, 'Actively listens to adults and classmates', 'សកម្មភាពស្តាប់អ្នកវ័យជំទង់និង​មិត្តរួមថ្នាក់', 1),
(3, 8, 'Holds books correctly and generally takes an interest in books', 'កាន់សៀវភៅបានត្រឹមត្រូវនិងមានចំណាប់អារម្មណ៍មួយលើសៀវភៅ', 1),
(3, 9, 'Holds a pencil correctly', 'កាន់ខ្មៅដៃបានត្រឹមត្រូវ', 1),
(3, 10, 'Can complete puzzles', 'អាចបញ្ចប់ល្បែងដាក់បំពេញ', 1),
(3, 11, 'Mathematical Development', 'ការអភិវឌ្ឈន៍ផ្នែកគណិតវិទ្យា', 0),
(3, 12, 'Recognizes basic shapes', 'ស្គាល់រូបរាងជាមូលដ្ឋាន', 1),
(3, 13, 'Counts reliably in English (1-10)', 'អាចរាប់លេខជាភាសាអង់គ្លេស(ពីលេខ១ដល់លេខ១០)', 1),
(3, 14, 'Counts reliably in Khmer (1-10)', 'អាចរាប់លេខជាភាសាខ្មែរ(ពីលេខ១ដល់លេខ១០)', 1),
(3, 15, 'Recognizes numbers', 'ស្គាល់ពីចំនួន', 1),
(3, 16, 'Is able to sort objects', 'អាចចាត់ថ្នាក់វត្ថុ', 1),
(3, 17, 'Sorts according to size', 'អាចចាត់ថ្នាក់ទៅតាមទំហំ', 1),
(3, 18, 'Joins in number rhymes, songs and games', 'ចូលរួមរាប់លេខទៅតាមពាក្យជួន ចំរៀង និងល្បែង', 1),
(3, 19, 'Knowledge and understanding of the world', 'ចំណេះដឹងនិងការយល់ពីពិភពលោក', 0),
(3, 20, 'Can identify different parts of the body', 'អាចសំគាល់ផ្នែកផ្សេងៗរបស់រូបរាងកាយ', 1),
(3, 21, 'Can name different animals', 'អាចប្រាប់ប្រភេទសត្វផ្សេងៗគ្នា', 1),
(3, 22, 'Can name different fruits and vegetables', 'អាចប្រាប់ប្រភេទផ្លែឈើនិងបន្លែផ្សេងៗគ្នា', 1),
(3, 23, 'Identifies different vehicles', 'សំគាល់យានជំនិះផ្សេងៗគ្នា', 1),
(3, 24, 'Physical Development', 'ការអភិវឌ្ឈន៍ខាងរូបរាងកាយ', 0),
(3, 25, 'Has well developed fine motor skills', 'មានការអភិវឌ្ឈន៍ល្អលើជំនាញប្រើដៃ', 1),
(3, 26, 'Enjoys physical activities', 'ចូលចិត្តសកម្មភាពធ្វើចលនារូបរាងកាយ', 1),
(3, 27, 'Has well developed gross motor skills', 'មានការអភិវឌ្ឈន៍លើជំនាញរូបរាយកាយ', 1),
(3, 28, 'Creative Development', 'ការអភិវឌ្ឍន៍ការឆ្នៃប្រឌិត', 0),
(3, 29, 'Can identify basic colours', 'អាចសំគាល់ពណ៌មូលដ្ឋាន', 1),
(3, 30, 'Joins in with music and movement activities', 'ចូលរួមជាមួយតន្ត្រីនិងសកម្មភាពចលនា', 1),
(3, 31, 'Likes to do art and craft activities', 'ចូលចិត្តធ្វើសកម្មភាពសិល្បៈនិងសិល្បៈរូបភាព', 1),
(3, 32, 'Life Skills / Personal Development', 'បទពិសោធន៍ជីវិតនិងការអភិវឌ្ឈន៍ផ្ទាល់ខ្លួន', 0),
(3, 33, 'Listens to my teacher', 'ស្តាប់គ្រូរបស់ខ្លួន', 1),
(3, 34, 'Can work independently and concentrate until my tasks are finished', 'ធ្វើកិច្ចការបានដោយខ្លួនឯងនិងផ្តោតការយកចិត្តទុកដាក់រហូតដល់កិច្ចការរបស់ខ្លួនបានបញ្ចប់', 1),
(3, 35, 'Can use my own ideas', 'អាចប្រើគំនិតផ្ទាល់របស់ខ្លួន', 1),
(3, 36, 'Understands and follow rules and routines', 'យល់និងធ្វើតាមច្បាប់និងកាលវិភាគ', 1),
(3, 37, 'Can share and take turns', 'អាចចែករំលែកនិងដឹងពីវេន', 1),
(3, 38, 'Tries new tasks', 'សាកល្បងធ្វើកិច្ចការថ្មី', 1),
(4, 0, 'Language Development', 'ការអភិវឌ្ឈន៍ភាសាសាស្ត្រ ', 0),
(4, 1, 'Understands and uses new words', 'យល់និងប្រើពាក្យថ្មី', 1),
(4, 2, 'Recognize, read and write name', 'ការស្គាល់ ការអាន  និងការសរសេរឈ្មាះ', 1),
(4, 3, 'Beginning to share ideas', 'ចាប់ផ្តើមចែករំលែកគំនិត', 1),
(4, 4, 'Uses appropriate spelling in written work', 'ប្រើការប្រកបត្រឹមត្រូវក្នុងកិច្ចការសរសេរ', 1),
(4, 5, 'Writes letters correctly', 'សរសេរអក្សរបានត្រឹមត្រូវ', 1),
(4, 6, 'Mastering phonics', 'ពូកែខាងបញ្ជេញសំលេង', 1),
(4, 7, 'Actively listens to adults and classmates', 'សកម្មភាពស្តាប់អ្នកវ័យជំទង់និង​មិត្តរួមថ្នាក់', 1),
(4, 8, 'Mathematical Development', 'ការអភិវឌ្ឈន៍ផ្នែកគណិតវិទ្យា', 0),
(4, 9, 'Number and Number Sense', 'លេខ និងការដឹងដោយញាណពីលេខ', 1),
(4, 10, 'Able to identify and use positional words', 'អាចសំគាល់ពាក្យនិងអាចប្រើពាក្យដាក់ត្រូវកន្លែង', 1),
(4, 11, 'Measurement', 'រង្វាស់ប្រវែង', 1),
(4, 12, 'Understands Patterns', 'ការយល់ដឹងពីការដាក់ជាគំរូ', 1),
(4, 13, 'Able to read o''clock times', 'អាចប្រាប់ពីពេលវេលា', 1),
(4, 14, 'Beginning to understand addition/subtraction', 'ការចាប់ផ្តើមយល់ពីវិធីបូកលេខ/ដកលេខ', 1),
(4, 15, 'Beginning to understand money', 'ការចាប់ផ្តើមស្គាល់ពីសន្លឹកប្រាក់', 1),
(4, 16, 'Khmer Language Arts', 'អក្សរសាស្ត្រខ្មែរ', 0),
(4, 17, 'Learning alphabet sounds', 'ការរៀនពីការបញ្ជេញសំលេងតាមលំដាប់អក្សរ', 1),
(4, 18, 'Understands and uses new words', 'យល់និងប្រើពាក្យថ្មី', 1),
(4, 19, 'Beginning to share ideas', 'ចាប់ផ្តើមចែករំលែកគំនិត', 1),
(4, 20, 'Actively listens to adults and classmates', 'សកម្មភាពស្តាប់អ្នកវ័យជំទង់និង​មិត្តរួមថ្នាក់', 1),
(4, 21, 'Topic', 'ប្រធានបទ', 0),
(4, 22, 'Can discuss about current topic', 'អាចពិភាគ្សាអំពីប្រធានបទទើបរៀនថ្មីៗ', 1),
(4, 23, 'Understands vocabulary used in current topic', 'យល់ពាក្យគន្លឹះដែលបានប្រើក្នុងប្រធានបទទើបរៀនថ្មីៗ', 1),
(4, 24, 'Physical Development', 'ការអភិវឌ្ឈន៍ខាងរូបរាងកាយ', 0),
(4, 25, 'Demonstrates fine motor control and coordination', 'បង្ហាញពីជំនាញប្រើដៃនិងប្រើត្រូវរបៀប', 1),
(4, 26, 'Moves in confidence in a variety of ways', 'ធ្វើចលនាយ៉ាងជឿជាក់ក្នុងសកម្មភាពផ្សេងៗគ្នាមួយ', 1),
(4, 27, 'Creative Development (Music and Art)', 'ការអភិវឌ្ឈន៍ភាពឆ្នៃប្រឌិត (តន្ត្រីនិងសិល្បៈ)', 0),
(4, 28, 'Enjoys music lessons', 'ចូលចិត្តមេរៀនតន្ត្រី', 1),
(4, 29, 'Explores colour and textures in creative activities', 'បង្ហាញការប្រើពណ៌និងវាយនភាពក្នុងសកម្មភាពឆ្នៃប្រឌិត', 1),
(4, 30, 'Life Skills / Personal Development', 'បទពិសោធន៍ជីវិតនិងការអភិវឌ្ឈន៍ផ្ទាល់ខ្លួន', 0),
(4, 31, 'Can express needs & feelings in appropriate ways', 'អាចប្រាប់ពីតំរូវការនិងអារម្មណ៍តាមរបៀបដែលត្រឹមត្រូវ', 1),
(4, 32, 'Understands the need for good behaviour', 'យល់ពីតំរូវការក្នុងអត្តចរិកដ៏ល្អ', 1),
(4, 33, 'Shows interest in activities', 'បង្ហាញចំណាប់អារម្មណ៍ក្នុងសកម្មភាពសិក្សា', 1),
(4, 34, 'Works independently', 'ធ្វើកិច្ចការបានដោយខ្លួនឯង', 0),
(4, 35, 'Works well in groups', 'ធ្វើកិច្ចការក្នុងក្រុមបានល្អ', 1),
(4, 36, 'Organized and looks after personal and school belongings', 'ការរៀបចំនិងថែរក្សារបស់​ផ្ទាល់ខ្លួននិងរបស់សាលា', 1),
(4, 37, 'Seeks help when needed', 'ស្វែងរកជំនួយនៅពេលត្រូវការ', 1),
(5, 0, 'English Language Arts', 'អក្សរសាស្ត្រអង់គ្លេស', 0),
(5, 1, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(5, 2, 'Reading', 'ការអាន', 1),
(5, 3, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(5, 4, 'Khmer Language Arts', 'អក្សរសាស្ត្រខ្មែរ', 0),
(5, 5, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(5, 6, 'Reading', 'ការអាន', 1),
(5, 7, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(5, 8, 'Mathematics', 'គណិតវិទ្យា', 0),
(5, 9, 'Numbers', 'លេខ', 1),
(5, 10, 'Shape, Space and Measure', 'រូបរាង,ចន្លោះ និងរង្វាស់ប្រវែង', 1),
(5, 11, 'Data Handling', 'ការប្រើទិន្នន័យ', 1),
(5, 12, 'Problem Solving', 'ការដោះស្រាយលំហាត់បញ្ហា', 1),
(5, 13, '', '', 0),
(5, 14, 'Topic (Science, Social Studies, Humanities, Art)', 'ប្រធានបទ (វិទ្យាសាស្ត្រ,សិក្សាសង្គម,មនុស្សសាស្ត្រ,សិល្បៈ)', 1),
(5, 15, 'Performing Arts', 'ស្នាដៃសិល្បៈ', 1),
(5, 16, 'Physical Education', 'ការសិក្សាពីរូបរាងកាយ', 1),
(5, 17, 'Study and Learning Skills', 'ជំនាញសិក្សានិងការរៀនសូត្រ', 0),
(5, 18, 'Works independently', 'ធ្វើកិច្ចការបានដោយខ្លួនឯង', 1),
(5, 19, 'Plays well in groups', 'កិច្ចការល្អជាក្រុម', 1),
(5, 20, 'Plays cooperatively with others', 'ការសហគ្នាក្នុងការលេងជាមួយអ្នកដ៏ទៃ', 1),
(5, 21, 'Follows directions', 'ស្តាប់ការណែនាំបង្រៀន', 1),
(5, 22, 'Organizes and looks after belongings', 'ការរៀបចំនិងថែរក្សារបស់​ផ្ទាល់ខ្លួន', 1),
(5, 23, 'Perseveres in problem solving', 'ព្យាយាមក្នុងការដោះស្រាយបញ្ហា', 1),
(5, 24, 'Makes good use of time', 'ប្រើប្រាស់ពេលវេលាបានល្អ', 1),
(5, 25, 'Seeks help when needed', 'ស្វែងរកជំនួយនៅពេលត្រូវការ', 1),
(5, 26, 'Completes classwork', 'បញ្ចប់កិច្ចការក្នុងថ្នាក់', 1),
(5, 27, 'Works neatly and carefully', 'កិច្ចការស្អាតនិងប្រុងប្រយ័ត្ន', 1),
(6, 0, 'English Language Arts', 'អក្សរសាស្ត្រអង់គ្លេស', 0),
(6, 1, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(6, 2, 'Reading', 'ការអាន', 1),
(6, 3, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(6, 4, 'Khmer Language Arts', 'អក្សរសាស្ត្រខ្មែរ', 0),
(6, 5, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(6, 6, 'Reading', 'ការអាន', 1),
(6, 7, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(6, 8, 'Mathematics', 'គណិតវិទ្យា', 0),
(6, 9, 'Numbers', 'លេខ', 1),
(6, 10, 'Shape, Space and Measure', 'រូបរាង,ចន្លោះ និងរង្វាស់ប្រវែង', 1),
(6, 11, 'Data Handling', 'ការប្រើទិន្នន័យ', 1),
(6, 12, 'Problem Solving', 'ការដោះស្រាយលំហាត់បញ្ហា', 1),
(6, 13, '', '', 0),
(6, 14, 'Topic (Science, Social Studies, Humanities, Art)', 'ប្រធានបទ (វិទ្យាសាស្ត្រ,សិក្សាសង្គម,មនុស្សសាស្ត្រ,សិល្បៈ)', 1),
(6, 15, 'Performing Arts', 'ស្នាដៃសិល្បៈ', 1),
(6, 16, 'Physical Education', 'ការសិក្សាពីរូបរាងកាយ', 1),
(6, 17, 'Study and Learning Skills', 'ជំនាញសិក្សានិងការរៀនសូត្រ', 0),
(6, 18, 'Works independently', 'ធ្វើកិច្ចការបានដោយខ្លួនឯង', 1),
(6, 19, 'Plays well in groups', 'កិច្ចការល្អជាក្រុម', 1),
(6, 20, 'Plays cooperatively with others', 'ការសហគ្នាក្នុងការលេងជាមួយអ្នកដ៏ទៃ', 1),
(6, 21, 'Follows directions', 'ស្តាប់ការណែនាំបង្រៀន', 1),
(6, 22, 'Organizes and looks after belongings', 'ការរៀបចំនិងថែរក្សារបស់​ផ្ទាល់ខ្លួន', 1),
(6, 23, 'Perseveres in problem solving', 'ព្យាយាមក្នុងការដោះស្រាយបញ្ហា', 1),
(6, 24, 'Makes good use of time', 'ប្រើប្រាស់ពេលវេលាបានល្អ', 1),
(6, 25, 'Seeks help when needed', 'ស្វែងរកជំនួយនៅពេលត្រូវការ', 1),
(6, 26, 'Completes classwork', 'បញ្ចប់កិច្ចការក្នុងថ្នាក់', 1),
(6, 27, 'Works neatly and carefully', 'កិច្ចការស្អាតនិងប្រុងប្រយ័ត្ន', 1),
(7, 0, 'English Language Arts', 'អក្សរសាស្ត្រអង់គ្លេស', 0),
(7, 1, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(7, 2, 'Reading', 'ការអាន', 1),
(7, 3, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(7, 4, 'Khmer Language Arts', 'អក្សរសាស្ត្រខ្មែរ', 0),
(7, 5, 'Speaking and Listening', 'ការនិយាយនិងការស្តាប់', 1),
(7, 6, 'Reading', 'ការអាន', 1),
(7, 7, 'Writing (including spelling)', 'ការសរសេរ(រួមទាំងការប្រកបពាក្យ)', 1),
(7, 8, 'Mathematics', 'គណិតវិទ្យា', 0),
(7, 9, 'Numbers', 'លេខ', 1),
(7, 10, 'Shape, Space and Measure', 'រូបរាង,ចន្លោះ និងរង្វាស់ប្រវែង', 1),
(7, 11, 'Data Handling', 'ការប្រើទិន្នន័យ', 1),
(7, 12, 'Problem Solving', 'ការដោះស្រាយលំហាត់បញ្ហា', 1),
(7, 13, '', '', 0),
(7, 14, 'Topic (Science, Social Studies, Humanities, Art)', 'ប្រធានបទ (វិទ្យាសាស្ត្រ,សិក្សាសង្គម,មនុស្សសាស្ត្រ,សិល្បៈ)', 1),
(7, 15, 'Performing Arts', 'ស្នាដៃសិល្បៈ', 1),
(7, 16, 'Physical Education', 'ការសិក្សាពីរូបរាងកាយ', 1),
(7, 17, 'Study and Learning Skills', 'ជំនាញសិក្សានិងការរៀនសូត្រ', 0),
(7, 18, 'Works independently', 'ធ្វើកិច្ចការបានដោយខ្លួនឯង', 1),
(7, 19, 'Plays well in groups', 'កិច្ចការល្អជាក្រុម', 1),
(7, 20, 'Plays cooperatively with others', 'ការសហគ្នាក្នុងការលេងជាមួយអ្នកដ៏ទៃ', 1),
(7, 21, 'Follows directions', 'ស្តាប់ការណែនាំបង្រៀន', 1),
(7, 22, 'Organizes and looks after belongings', 'ការរៀបចំនិងថែរក្សារបស់​ផ្ទាល់ខ្លួន', 1),
(7, 23, 'Perseveres in problem solving', 'ព្យាយាមក្នុងការដោះស្រាយបញ្ហា', 1),
(7, 24, 'Makes good use of time', 'ប្រើប្រាស់ពេលវេលាបានល្អ', 1),
(7, 25, 'Seeks help when needed', 'ស្វែងរកជំនួយនៅពេលត្រូវការ', 1),
(7, 26, 'Completes classwork', 'បញ្ចប់កិច្ចការក្នុងថ្នាក់', 1),
(7, 27, 'Works neatly and carefully', 'កិច្ចការស្អាតនិងប្រុងប្រយ័ត្ន', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `template_name` varchar(256) NOT NULL,
  `columns` int(1) NOT NULL,
  `key` tinyint(1) NOT NULL,
  `height_limit` int(2) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`template_id`, `school_id`, `template_name`, `columns`, `key`, `height_limit`) VALUES
(1, 2, 'Grade 2', 4, 1, 17),
(2, 2, 'Kindergarten 2', 3, 0, 19),
(3, 2, 'Kindergarten 1', 3, 0, 19),
(4, 2, 'Kindergarten 3', 3, 0, 19),
(5, 2, 'Grade 1', 4, 1, 17),
(6, 2, 'Grade 3', 4, 1, 17),
(7, 2, 'Grade 4', 4, 1, 17);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
