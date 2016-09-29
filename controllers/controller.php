<?php
	class controller {
		private $db;

		public function __construct(MySQLHandler $db) {
			$this -> db = $db;
		}
		
		public function login($email, $password) {
            $logindb = $this -> db;
			$sql = "SELECT * FROM `tblAdmins` WHERE Email = '$email' AND Password = '$password' LIMIT 1";
			$result = $logindb -> Select($sql);

			if (count($result) > 0) $x = "true";
            else $x = "false";
			
			return $x;
        }

		public function getStudents() {
			$studentsDb = $this -> db;
			$sql = "SELECT A.Id, A.Name, A.StudentNumber, B.Level, A.Age, A.Guardian, A.GuardianContact FROM tblstudents AS A INNER JOIN tbllevels AS B ON A.LevelId = B.Id
";
			$result = $studentsDb -> Select($sql);

			return $result;
		}

		public function getPhases() {
			$phasesDb = $this -> db;
			$sql = "";

			$result = $phasesDb -> Select($sql);

			return $result;
		}

		public function getSubscribers() {
			$subscribersDb = $this -> db;
			$sql = "SELECT * FROM tblSubscribers";

			$result = $subscribersDb -> Select($sql);

			return $result;
		}

		public function getLevels() {
			$levelsDb = $this -> db;
			$sql = "SELECT * FROM tbllevels";

			$result = $levelsDb -> Select($sql);

			return $result;
		}

		public function getClasses() {
			$classesDb = $this -> db;
			$sql = "SELECT * FROM tblclasses";

			$result = $classesDb -> Select($sql);

			return $result;
		}

		public function getGuardianTypes() {
			$guardianTypesDb = $this -> db;
			$sql = "SELECT * FROM tblguardiantypes";

			$result = $guardianTypesDb -> Select($sql);

			return $result;
		}

		public function AddStudent($name, $studentNumber, $email, $levelId, $age, $classId, $guardian,
        $guardianTypeId, $contact) {
			$DATABASE = 'dbweb'; 
			$USERNAME = 'root'; 
			$PASSWORD = ''; 
			$SERVER = 'localhost';

			$conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);

			if ($conn -> connect_error) die("Connection failed: " . $conn -> connect_error);

			$stmt = $conn -> prepare("INSERT INTO tblstudents (Name, StudentNumber, " +
				"Email, LevelId, Age, ClassId, Guardian, GuardianType, GuardianContact) " +
				"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt -> bind_param("sssiiisis", $name, $studentNumber, $email, $levelId, $age, $classId,
				$guardian, $guardianTypeId, $contact);
			$stmt -> execute();
		}
	}
?>