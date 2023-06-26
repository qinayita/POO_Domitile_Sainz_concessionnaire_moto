Partie théorique (5 points)
Donner 5 méthodes magiques que vous avez étudié en PHP OO. Expliquez les éléments
déclencheurs de l’exécution de la méthode magique (0.5 point par méthode)
Pour chacune des méthodes ci-dessus proposez un exemple de script qui appellera la méthode de manière implicite
(0.5 point par méthode)


1. __construct() - Elle est automatiquement appelée lors de la création d'un nouvel objet à partir d'une classe.
   class Moto {
   public function __construct() {
   echo 'Une nouvelle moto a été créée.';
   }
   }
   $moto = new Moto(); // affiche "Une nouvelle moto a été créée."

2. __destruct() - Elle est automatiquement appelée lorsqu'un objet n'est plus utilisé ou lorsqu'il est explicitement détruit avec unset().
   class Moto {
   public function __destruct() {
   echo 'La moto a été détruite.';
   }
   }
   $moto = new Moto();
   unset($moto); // affiche "La moto a été détruite."

3. __get($property) - Elle est automatiquement appelée lorsque nous tentons d'accéder à une propriété qui n'est pas accessible ou inexistante.
   class Moto {
   private $marque = "Yamaha";

   public function __get($property) {
   if (property_exists($this, $property)) {
   return $this->$property;
   }
   }
   }
   $moto = new Moto();
   echo $moto->marque; // affiche "Yamaha"

4. __set($property, $value) - Elle est automatiquement appelée lorsque nous tentons de modifier une propriété qui n'est pas accessible ou inexistante.
   class Moto {
   private $marque;

   public function __set($property, $value) {
   if (property_exists($this, $property)) {
   $this->$property = $value;
   }
   }
   }
   $moto = new Moto();
   $moto->marque = "Honda"; // déclenche la méthode __set()

5. __toString() - Elle est automatiquement appelée lorsque nous essayons de convertir un objet en une chaîne de caractères avec echo ou print.
   class Moto {
   public $marque = "Yamaha";

   public function __toString() {
   return $this->marque;
   }
   }
   $moto = new Moto();
   echo $moto; // affiche "Yamaha"


