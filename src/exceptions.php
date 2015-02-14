<?php
namespace Bazo\Commands;

class RuntimeException extends \RuntimeException {}
class MultipleHandlersFoundException extends RuntimeException {}
class HandlerNotFoundException extends RuntimeException {}
class HandlerDoesNotImplementInterfaceException extends RuntimeException {}
