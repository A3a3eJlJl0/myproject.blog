<?php
namespace MyProject\Views;

class View
{
    private $templatesPath;
    private $extraVars = [];

    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function setExtraVar(string $name, $value) : void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], int $responseCode = 200)
    {
        http_response_code($responseCode);

        extract($this->extraVars);
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    public function displayJson(array $data, $code = 200)
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }


}