    <?php
    /** 
     * EpollSocketServer Class (use libevent) 
     * By James.Huang <shagoo#gmail.com> 
     *  
     * Defined constants: 
     *  
     * EV_TIMEOUT (integer) 
     * EV_READ (integer) 
     * EV_WRITE (integer) 
     * EV_SIGNAL (integer) 
     * EV_PERSIST (integer) 
     * EVLOOP_NONBLOCK (integer) 
     * EVLOOP_ONCE (integer) 
     **/
    set_time_limit(0);

    class EpollSocketServer
    {

        private static $socket;

        private static $connections;

        private static $buffers;

        function EpollSocketServer($port)
        {
            global $errno, $errstr;
            
            if (! extension_loaded('libevent')) {
                die("Please install libevent extension firstly\n");
            }
            
            if ($port < 1024) {
                die("Port must be a number which bigger than 1024\n");
            }
            
            $socket_server = stream_socket_server("tcp://0.0.0.0:{$port}", $errno, $errstr);
            if (! $socket_server)
                die("$errstr ($errno)");
            
            stream_set_blocking($socket_server, 0); // 非阻塞
            
            $base = event_base_new();
            $event = event_new();
            event_set($event, $socket_server, EV_READ | EV_PERSIST, array(
                __CLASS__,
                'ev_accept'
            ), $base);
            event_base_set($event, $base);
            event_add($event);
            event_base_loop($base);
            
            self::$connections = array();
            self::$buffers = array();
        }

        function ev_accept($socket, $flag, $base)
        {
            static $id = 0;
            
            $connection = stream_socket_accept($socket);
            stream_set_blocking($connection, 0);
            
            $id ++; // increase on each accept
            
            $buffer = event_buffer_new($connection, array(
                __CLASS__,
                'ev_read'
            ), array(
                __CLASS__,
                'ev_write'
            ), array(
                __CLASS__,
                'ev_error'
            ), $id);
            
            print_r($id.' --- '.$connection.'--'.$buffer);
            echo PHP_EOL;
            
            event_buffer_base_set($buffer, $base);
            event_buffer_timeout_set($buffer, 30, 30);
            event_buffer_watermark_set($buffer, EV_READ, 0, 0xffffff);
            event_buffer_priority_set($buffer, 10);
            event_buffer_enable($buffer, EV_READ | EV_PERSIST);
          
            // we need to save both buffer and connection outside
            self::$connections[$id] = $connection;
            self::$buffers[$id] = $buffer;
        }

        function ev_error($buffer, $error, $id)
        {
            event_buffer_disable(self::$buffers[$id], EV_READ | EV_WRITE);
            event_buffer_free(self::$buffers[$id]);
            fclose(self::$connections[$id]);
            unset(self::$buffers[$id], self::$connections[$id]);
            
            echo 'error:id='.$id.',length='.strlen($error);
            echo PHP_EOL.PHP_EOL.PHP_EOL;
            
        }

        function ev_read($buffer, $id)
        {
            static $ct = 0;
            $ct_last = $ct;
            $ct_data = '';
            
            echo 'event_buffer_read start ........'.$id.PHP_EOL;
            
            while ($read = event_buffer_read($buffer, 1024)) {
                $ct += strlen($read);
                $ct_data .= $read;
            }
            echo 'event_buffer_read end ........'.$id.PHP_EOL;
            $ct_size = ($ct - $ct_last) * 8;
            //echo "[$id] " . __METHOD__ . " > " . $ct_data . "\n";
//             event_buffer_write($buffer, "Received $ct_size byte data./r\n");
            
            event_buffer_write($buffer, $this->add_header('hello world'));

            
//             self::ev_error($buffer, '', $id);

//             fclose(self::$connections[$id]);
// sleep(1);
// fclose(self::$connections[$id]);
        }

        function ev_write($buffer, $id)
        {
//             echo $this->not_found();

//             if ($id == 8){
//                 sleep(5);
//             }
           
            
            
            echo "[$id] " . __METHOD__ . "\n";
            
//             sleep(1);
//             fclose(self::$connections[$id]);
            
//             event_buffer_disable(self::$buffers[$id], EV_READ | EV_WRITE);
//             event_buffer_free(self::$buffers[$id]);

            $this->ev_error($buffer, 'error string', $id);
            
        }
        
        private function not_found()
        {
            $content = "<h1>File Not Found </h1>";
            return "HTTP/1.1 404 File Not Found\r\nConnection: close\r\nContent-Type: text/html\r\nContent-Length: " . strlen($content) . "\r\n\r\n" . $content;
        }
        
        /**
         * 加上头信息
         *
         * @param
         *            $string
         * @return string
         */
        private function add_header($string)
        {
//             for ($i=0;$i<100000;$i++){
//                 $string .=$i;
//             }
            $header="HTTP/1.1 200 OK\r\nContent-Length: ". strlen($string) . "\r\nKeep-Alive: timeout=5, max=100\r\nConnection: Keep-Alive\r\nContent-Type: text/html\r\n\r\n".$string;
            return $header;
            return  "HTTP/1.1 200 OK\r\nContent-Length: " . strlen($string) . "\r\nConnection: close\r\nServer: mengkang\r\n\r\n" . $string;
        }
    }
    new EpollSocketServer(2001);  