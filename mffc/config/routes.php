<?php

use NoahBuscher\Macaw\Macaw;

Macaw::get('fuck', function() {
  echo "�ɹ���";
});

Macaw::get('(:all)', function($fu) {
  echo 'δƥ�䵽·��<br>'.$fu;
});

Macaw::dispatch();

