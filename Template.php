<?php 

    class Template {

        /*
            
            (string)
        */
        protected $_template_maker = null;
        protected $_data           = [];

        public function __construct(){ }

        public function set_data( $data ){
            if(!is_array($data)){
                throw new \Exception('Dados inválidos!');
            }
            $this -> _data = $data;
        }

        public function set_template( $template_url ){
            if(!is_file($template_url)){
                throw new \Exception('Url do template é inválida!');
            }
            $this -> template = file_get_contents($template_url);
        }

        /*
            @Params  (array) $array_keys  
            @Params  (string) $prefix  

            @Returns (array) $array_keys
        */
        protected function _load_array_keys ( $array_keys , $prefix = ''){ 

            if(!is_array($array_keys)){
                throw new \Exception('Dados inválidos!');
            } 
            array_walk( $array_keys , function( &$value , $key ) use ($prefix)  {
                $value = '{'.$prefix.$value.'}';
            });

            return $array_keys;
        }

        /*
            @Params (string) $file 
            @Params (array)  $vars 
            @Params (string) $prefix  
        */
        public function load_file( $file , $vars = [], $prefix = ''){

            if(!is_file($file))
                return;  

            if( !is_string($prefix) ){
                throw new \Exception('Prefixo inválido!');
            }

            $prefix = !empty($prefix) ? $prefix.'_'  : null; 

            $data            = $this -> _data;
            $template_maker  = null;
            $file            = file_get_contents($file);

            if( is_array($vars) ){  
                foreach( $vars as $key => $values ):
                    if( is_array($values) ){

                        $var_keys   = array_keys($values); 
                        $var_values = array_values($values);

                        $var_keys   = $this -> _load_array_keys($var_keys, $prefix); 

                        $page = str_replace( $var_keys , $var_values , $file);
                    }else{ 
                        $page = str_replace( '{'.$prefix.$key.'}' , $values , $file);
                    }

                    $data_keys   = array_keys($data); 
                    $data_values = array_values($data); 
                    $data_keys   = $this -> _load_array_keys($data_keys);

                    $template_maker .= str_replace( $data_keys , $data_values , $page);
                endforeach; 
            }

            //Vamos setar a página gerada
            $this -> _template_maker .= $template_maker;
        }

        /*
            Monta a página
        */
        public function make_page(){
            //Vamos limpar os dados  
            $this -> _data = [];

            $page = str_replace( '{load_template}'  , $this->_template_maker , $this -> template );
            
            echo $page;
        }

    }

?>