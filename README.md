# php_graph_wrappers
PHP Wrappers for PlantUML-server and Graphviz-server

# Required
sudo docker pull plantuml/plantuml-server:jetty
sudo docker pull omerio/graphviz-server

sudo docker run -d -p 8585:8585 omerio/graphviz-server 8585
sudo docker run -d -p 8586:8081 plantuml/plantuml-server:jetty

# Example of running wrapper

![Alt Text](https://api.dawnbringer.net/graph/dot/?
digraph G {
    aize ="4,4";
    main [shape=box];
    main -> parse [weight=8];
    parse -> execute;
    main -> init [style=dotted];
    main -> cleanup;
    execute -> { make_string; printf};
    init -> make_string;
    edge [color=red];
    main -> printf [style=bold,label="100 times"];
    make_string [label="make a string"];
    node [shape=box,style=filled,color=".7 .3 1.0"];
    execute -> compare;
  })
