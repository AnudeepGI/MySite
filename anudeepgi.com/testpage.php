<style>

.wrapper {
  display: flex;  
    flex-direction: column;
      font-weight: bold;
  text-align: center;
}

.wrapper > * {
  padding: 10px;
  flex: 1 100%;
}


.main {
  text-align: left;
  background: deepskyblue;
}

.aside {  
	background:red;
}


@media all and (min-width: 600px) {



}

@media all and (min-width: 800px) {
.wrapper{
flex-direction: row;
}
}

body {
margin :0px;
}


</style>


<div class="wrapper">
  <article class="main">
    <p>
      Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
      Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. 
      Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.
    </p>  
  </article>
  <aside class="aside">
	<div>test1</div>  
	<div>test2</div>  
	<div>test3</div>  
  </aside>
</div>


