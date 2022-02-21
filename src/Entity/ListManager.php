<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="List")
 */

class ListManager {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner le nom de la liste")
     * @Assert\Length(
     *  min=2,
     *  max=80,
     *  minMessage="Le nom saisie est trop court",
     *  maxMessage="Le nom saisie est trop long"
     * )
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la couleur de la liste")
     * @Assert\Length(
     *  min=2,
     *  max=10,
     *  minMessage="La couleur saisie est trop courte",
     *  maxMessage="La couleur saisie est trop longue"
     * )
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="list", orphanRemoval=true)
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }



    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setList($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getList() === $this) {
                $task->setList(null);
            }
        }

        return $this;
    }

    /**
     * Get min=2,
     */ 
    public function getName()
    {
        return $this->name;
    }

}
