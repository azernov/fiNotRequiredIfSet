<?php
/**
 * Валидатор, проверяющий установку хотя бы одного из полей
 * Для данного валидатора в при вызове formit необходимо указать параметры:
 * customValidators = 'foNotRequiredIfSet'
 * [поле].fiNotRequiredIfSetMessage = 'Текст ошибки для поля'
 *
 * в параметре validate для полей, валидируемых этим валидатором нужно указать
 * .....поле:fiNotRequiredIfSet=поле2|поле3,поле2:fiNotRequiredIfSet=поле|поле3.....
 *
 * Тогда если хотя бы одно из полей заполнено, у второго не будет ошибки "Укажите поле"
 *
 * @var string $key
 * @var string $value
 * @var string $param
 * @var string $type
 * @var fiValidator $validator
 */

$checkFields = explode('|',$param);
$formit = &$validator->formit;

$oneIsSet = !empty($value);

//Все поля формы
$allFormValues = $formit->request->dictionary->toArray();

if(!$oneIsSet){
    foreach($checkFields as $checkField){
        $checkValue = $allFormValues[$checkField];
        if(!empty($checkValue)){
            $oneIsSet = true;
            break;
        }
    }
}


if(!$oneIsSet){
    $message = $formit->config[$key.'.fiNotRequiredIfSetMessage'];
    if(!$message){
        $message = 'Укажите '.$key;
    }
    $validator->addError($key, $message);
    return false;
}

return true;
