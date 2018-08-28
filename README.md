# php_graph_wrappers
PHP Wrappers for PlantUML-server and Graphviz-server

# Required
sudo docker pull plantuml/plantuml-server:jetty
sudo docker pull omerio/graphviz-server

sudo docker run -d -p 8585:8585 omerio/graphviz-server 8585
sudo docker run -d -p 8586:8081 plantuml/plantuml-server:jetty

# Embed PlantUML in AMP-pages

```
/* Need to add some CSS for PlantUML scaling to work out of the box */
amp-img.contain img{
  object-fit: contain;
}

.fixed-height-container{
  position: relative;
  width: 100%;
}

.h300{
  height: 300px;
}
```


amp-html
```
<amp-img
  class="contain" 
  layout="fill"
  width="600"
  height="400"
  src='https://g.gravizo.com/svg?
@startuml;

actor User;
participant "First Class" as A;
participant "Second Class" as B;
participant "Last Class" as C;

User -> A: DoWork;
activate A;

A -> B: Create Request;
activate B;

B -> C: DoWork;
activate C;

C --> B: WorkDone;
destroy C;

B --> A: Request Created;
deactivate B;

A --> User: Done;
deactivate A;

@enduml
'></amp-img>
```

# Example of running wrapper on github (using Gravizo)

On github you need to use source with custom marks. The regular embed doesn't work as easily since the github server tends to break it.

![Alt text](https://g.gravizo.com/source/custom_mark10?https%3A%2F%2Fraw.githubusercontent.com%2FTLmaK0%2Fgravizo%2Fmaster%2FREADME.md)

<details> 
<summary></summary>
custom_mark10
  digraph G {
    size ="4,4";
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
  }
custom_mark10
</details>
