<?php

class Validator
{
    // приватная переменная для обозначения прошла ли валидация и массив для ошибок
    private $passed = false, $errors = [];

    // метод для проверки соответствия введенным критериям, т.е. сама валидация
    // на вход поступает сама информация и список требований к ней для валидации
    // резльтат и ошибки отражаются в приватных переменных, возвращается объект
    public function check($source, $items = [])
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item];

                if ($rule == 'required' and empty($value)) {
                    $this->addError("{$item} is required");
                } elseif (!empty($value)) {
                    // задание правил по которым можно проводить валидацию
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }

                            break;

                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters");
                            }

                            break;

                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$item} must match the {$rule_value} field");
                            }

                            break;

                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$item} is not an email");
                            }

                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

        return $this;
    }

    // метод добавления текста ошибки в приватный массив
    // для внутреннего использования в методе check()
    private function addError($error)
    {
        $this->errors[] = $error;
    }

    // метод для получения массива ошибок
    public function errors()
    {
        return $this->errors;
    }

    // метод для получения флага прохождения валидации
    public function passed()
    {
        return $this->passed;
    }
}
