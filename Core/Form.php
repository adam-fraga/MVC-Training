<?php

namespace App\Core;

class Form
{
    private string $formCode = '';

    /** Génère le formulaire html
     * @return string
     */
    public function create(): string
    {
        return $this->formCode;
    }

    /** Validateur de formulaire check si tout les champs sont remplis et correspondent
     * @param array $form Tableau issus du formulaire
     * @param array $champs Tableau listant les champs obligatoire
     * @return bool
     */
    public static function validate(array $form, array $champs): bool
    {
        //AJOUTER LES TEST DES CHAMPS

        //Parcout les champs
        foreach ($champs as $champ) {
            //vérifie si le champs est tabsent ou vide
            if (!isset($form[$champ]) || empty($form[$champ])) {
                return false;
            }
        }
        return true;
    }

    /** Ajotue les attributs envoyé à la balise
     * @param array $attributes Attributs tableau associatif ['class' => 'form-control', 'required' => 'true']
     * @return string Chaine de caractere généré
     */
    private function addAttributes(array $attributes): string
    {
        //initialiser chaine de caractere
        $str = '';
        //On liste els attributs court (sans valeur)
        $short = ['checked', 'disabled', 'readonly', 'required', 'autofocus', 'multiple', 'novalidate', 'formnovalidate'];
        foreach ($attributes as $attribute => $value) {
            //Si l'attribut est dans la liste des attributs courts
            if (in_array($attribute, $short) && $value == true) {
                $str .= " $attribute";
            } //On ajoute attribut = 'valeur';
            else {
                $str .= " $attribute = '$value'";
            }
        }

        return $str;
    }

    /** Balsie d'ouverture du formulaire
     * @param string $method Method du formaire post ou get
     * @param string $action action du formulaire
     * @param array $attributes attributs du formulaire
     * @return $this
     */
    public function debutForm(string $method = 'post', $action = '#', array $attributes = []): self
    {
        //On crée la balise form
        $this->formCode .= "<form action ='$action' method = '$method'";
        //Ajout des éventuels attribut
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        return $this;
    }

    /** Methode de fermeture du formulaire
     * @return $this
     */
    public function finForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /** Ajout d'un label
     * @param string $for
     * @param string $text
     * @param array $attributes
     * @return $this
     */
    public function addLabelFor(string $for, string $text, array $attributes = []): self
    {
        //Ouverture de la balise
        $this->formCode .= "<label for='$for'";
        //Ajout des attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        //Ajout du texte
        $this->formCode .= ">$text</label>";
        return $this;
    }

    public function addInput(string $type, string $name, array $attribute = []): self
    {
        //Ouvre la balise
        $this->formCode .= "<input type='$type' name='$name'";
        //Concatenation des attributs
        $this->formCode .= $attribute ? $this->addAttributes($attribute) . '>' : '>';

        return $this;
    }

    public function addTextArea(string $name, string $value = '', array $attributes = []): self
    {
        //Ouverture de la balise
        $this->formCode .= "<textarea name='$nom'";
        //Ajout des attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        //Ajout du texte
        $this->formCode .= ">$value</textarea>";
        return $this;
    }

    public function addSelect(string $name, array $options, array $attributes = []): self
    {
        //Ouverture de la balise select
        $this->formCode .= "<select name='$name'";
        //On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';
        //On ajoute les options
        foreach ($options as $value => $text) {
            $this->formCode .= "<option value='$value'>$text</option>";
        }
        //On ferme la balise select
        $this->formCode .= "</select>";
        return $this;
    }

    public function addButton(string $text, array $attributes = []): self
    {
        //Ouvre la balsie button
        $this->formCode .= "<button'";
        //Ajout des attributs du button
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        //Ferme la balise button
        $this->formCode .= "<'$text'</button>";
        return $this;
    }
}