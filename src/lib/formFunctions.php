<?php

/**
 * Rend un champ de formumlaire (input)
 *
 * @param string $name  nom de la variable associée qui sera créée lors de la
 *                      soumission du formulaire
 * @param string $value valeur par défaut pour le champ
 *
 * @return string chaîne html
 */
function formInput(
    string $name,
    string $value = '',
    string $type = 'text'
): string {

    $html = <<<html
    <input class="fondColore" id="$name" type="$type" name="$name" value="$value">
html;

    return $html;

}

/**
 * Génère un label à associer à un input (@param string $label
 *
 * @param string $inputNameLinked
 *
 * @return string
 * @see formInput() )
 */
function formLabel(string $label, string $inputNameLinked): string
{
    $html = <<<html
    <label for="$inputNameLinked">$label</label>
html;

    return $html;

}

/**
 * Génère un champ de saisie avec son label
 *
 * @param string $name    nom de l'input
 * @param string $label   intitulé du label
 * @param string $value   valeur par défaut de l'input
 * @param string $type    type de l'input
 * @param string $wrapTag balise html qui encadre le libellé et le champ du
 *                        formulaire (châine vide par défaut)
 *
 * @return string chaîne HTML
 */
function formRow(
    string $name,
    string $label,
    string $value = '',
    string $type = 'text',
    string $wrapTag = ''
): string {
    $html = '';
    if ($wrapTag != '') {
        $html .= "<$wrapTag>";
    }
    if ($label != '') {
        $html .= formLabel($label, $name); //$html = $html.formLabel();
    }
    $html .= formInput($name, $value, $type);
    if ($wrapTag != '') {
        $html .= "</$wrapTag>";
    }


    return $html;

}


/**
 * Rôle @param array $args @see formRow
 *
 * @return string
 * @see formRow()
 */
function formRow2(
    array $args
): string {
    $html = '';
    if ($args['wrapTag'] != '') {
        $html .= "<".$args['wrapTag'].">";
    }
    if ($args['label'] != '') {
        $html .= formLabel(
            $args['label'],
            $args['name']
        ); //$html = $html.formLabel();
    }
    $html .= formInput($args['name'], $args['value'], $args['type']);
    if ($args['wrapTag'] != '') {
        $html .= "</".$args['wrapTag'].">";
    }


    return $html;

}

/**
 * Rend la balise de début d'un formulaire
 *
 * @param string $action page qui reçoit les données soumises par le formulaire
 *
 * @return string chaîne HTML
 */
function formStart(string $action): string
{
    $html = <<<html
        <form action="$action" method="post">
html;

    return $html;

}

/**
 * Rend la fin de la balise d'un formulaire
 *
 * @return string chaîne HTML
 */
function formEnd(): string
{
    return '</form>';
}

/**
 * Génère un formulaire complet
 *
 * @param string $action page qui récupère les données
 * @param array  $items tableau dont chaque valeur est un tableau associatif avec les clés suivantes :
 *                      [
 *                      'name' => 'nom de l'élément input',
 *                      'label' => 'intitulé du label',
 *                      'value' => 'valeur par défaut de l'input'
 *                      'type' => 'type de l'input (text, color, email,...)'
 *                      'wrapTag' => balise html qui enveloppe le libellé et l'input
 *                      ]
 *
 * @return string chaîne HTML contenant tout le code du formulaire
 */
function formForm(string $action, array $items)
{
    $html = formStart($action);

    foreach ($items as $key => $arrayValues) {
//        var_dump($key);
        $html .= formRow(
            $items[$key]['name'],
            $items[$key]['label'],
            $items[$key]['value'],
            $items[$key]['type'],
            $items[$key]['wrapTag'],
        );
         
     }


    $html .= formEnd();

    return $html;

}

