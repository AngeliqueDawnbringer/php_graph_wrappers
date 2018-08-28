# php_graph_wrappers
PHP Wrappers for PlantUML-server and Graphviz-server

# Required
sudo docker pull plantuml/plantuml-server:jetty
sudo docker pull omerio/graphviz-server

sudo docker run -d -p 8585:8585 omerio/graphviz-server 8585
sudo docker run -d -p 8586:8081 plantuml/plantuml-server:jetty

# Example of running wrapper

![alt text](https://g.gravizo.com/svg?'
 digraph G {
   main -> parse -> execute;
   main -> init;
   main -> cleanup;
   execute -> make_string;
   execute -> printf
   init -> make_string;
   main -> printf;
   execute -> compare;
  }')
