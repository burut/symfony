class Product
{
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;

/**
* @ORM\Column(type="string", length=100)
*/
protected $name;

/**
* @ORM\Column(type="decimal", scale=2)
*/
protected $address;

/**
* @ORM\Column(type="text")
*/
protected $phone;
}
