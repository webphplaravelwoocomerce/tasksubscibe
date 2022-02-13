const form = `

 <div class="container">
     <div class="row">
       <div class="form_container">
           <h1>Subscribe us</h1>
         
           <form id="form_container">            
                  
                     <input id="name" class="form_input" type="text" name="fname" placeholder="Enter your name" >
                  
                    
                     <input id="email" class="form_input" type="email" name="email" placeholder="Enter your Email" >


                     <input id="btn_submit" class="btn" type="submit" value="Subscribe">
               
             </form>
             <div id="app"></div>
             <span id="text"></span>
       </div>
     </div>
 </div>

 `;

 document.body.innerHTML = form;

    const submit = document.querySelector('#btn_submit');

    submit.addEventListener('click', sendData);

 function sendData(e){
    e.preventDefault();
  
      const username = document.querySelector('#name').value;
      const email = document.querySelector('#email').value;
      const text = document.querySelector('#text');
      const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      
        let check = true;
             
       //name check  **********************
     if(username == '' || username.length > 20  ){
         text.innerHTML = "Max 20 character, cannot be empty";

        return check = false;
     }else{
        text.innerHTML ='';
     }
     //email check ***********************

     if( !email.match(pattern)  ){
         
        text.innerHTML ="Please fill email in proper format";
        return check = false;
     }else{
        text.innerHTML ='';
     }

     //Send data ***********************
     if(check == true){

     const data ={
            fname: username,
            email: email,
     }
     const jsonString = JSON.stringify(data);

     const xhr = new XMLHttpRequest();

     xhr.open('POST',"asset/php/class.task.php");
     xhr.setRequestHeader("Content-type", "application/json");

     xhr.onload = function(){
         if(xhr.status == 200){
            document.querySelector('#app').innerHTML = xhr.responseText;
         }
     }

     xhr.send(jsonString);
     }
 }
 



