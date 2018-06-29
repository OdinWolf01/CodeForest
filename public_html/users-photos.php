
<style>
*{
	margin:0;
	padding:0;
	box-sizing:border-box;
}

.flex-box{
	width:100px;
	position:relative;
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: flex-start;
}

.flex-item {
	display:inline-block;
  	width: 20%;
	height:auto;
	margin:2.5%;
	min-width:150px;
	position:relative;
	overflow:hidden;
}

.flex-item img {
	display:block;
  	width: 100%;
	height: auto;
}

@media only screen and (max-width:800px){
	.flex-item {
		width: 30.33%;
		margin:1.5%;
	}
}

@media only screen and (max-width:560px){
	.flex-item {
		width: 45%;
		margin:2.5%;
	}
}

@media only screen and (max-width:360px){
	.flex-item {
		width: 100%;
		margin:2.5% 0;
	}
}

</style>


<div class="flex-box">
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>

	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>

	<div class="flex-item">
		<img src="https://placeholdit.imgix.net/~text?txtsize=28&bg=0099ff&txtclr=ffffff&txt=300%C3%97300&w=300&h=300&fm=png">
	</div>
	
</div>