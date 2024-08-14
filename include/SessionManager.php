<?php
class SessionManager {

    public function __construct() {
       
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

   
    public function isUserLoggedIn() {
        if (!isset($_SESSION['utilisateur'])) {
            $this->redirect("connexion.php");
        }
    }

    
    private function redirect($url) {
        header("Location: " . $url);
        exit();
    }


    public function getLoggedInUser() {
        return isset($_SESSION['utilisateur']) ? $_SESSION['utilisateur'] : null;
    }

  
    public function logout() {
      
        $_SESSION = array();

      
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

       
        session_destroy();

  
        header("Location: index.php");
        exit();
    }
}
?>
