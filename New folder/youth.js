*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.body{
        background-color: #F9F9F9;
    color: #333333;
}

.hero{
    height: 100vh;
    background: linear-gradient( to right, #ff9966, #ff5e62);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 2rem;
    margin-bottom: 55px;
    
}
.hero h1{
    font-size: 5rem;
    margin-bottom: 1rem;
    color: #fceabb;
   font-weight: 900;
}
.hero h5{
    font-size: 1.5rem;
    margin-bottom:1rem ;
}
.hero p{
    font-size: 20px;
    max-width: 600px;
    margin-bottom: 2rem;
}
.btn-primary{
   background-color: #ff5e62;
   display: flex;
   border: none;
   justify-content: center;
   align-items: center;
   font-size: 15px;
   font-weight: 700;
    height: 40px; ;
   width: 200px;
   border-radius: 16px;
   color:#fff;
   transition: background-color 0.3s,color 0.3s;
}
.btn-secondary{
   background-color: #ffffff;
   height: 40px; ;
   display: flex;
   width: 200px;
   font-size: 16px;
   font-weight: 900;
   justify-content: center;
   align-items: center;
   border: none;
   border-radius: 16px;
   color: rgb(17, 15, 15);
   transition: background-color 0.3s,color 0.3s;
}
.hero .btn-primary:hover{
    background-color: #ff9966;
}
.hero .btn-secondary:hover{
    background-color: #333;
}

.btn-container{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}

.navbar{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    position: fixed;
    width: 100%;
     height: 60px;
     top: 0;
     background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0), #1e3c72);
     z-index: 1000; 

   }
.size-6{
   width: 21px;

}
.youth-logo{
    color: #ff5e62;
    height: 40px;
    font-weight: 700;
    
    
}
.navbar ul{
    display: flex;
    list-style: none;
    font-size: 18px;
    gap: 20px;
    
}
.navbar a{
    color: #000000;
    text-decoration: none;
    font-weight: 600;
}

.navbar::after{
    background-color: #ffffff;
}
.red{
    color: #1e3c72;
    font-size: 1.7rem;
    font-weight: 900;
    font-size: "Roboto", "sans-serif";

}
.hero1 h1 {
    display: flex;
    justify-content: center;
    font-family: "Roboto", "sans-serif";
    font-size: 2.4rem;
    font-weight: 900;
   
}
p{
    display: flex;
    justify-content: center;
    font-size: 1.2rem;
}

.cards-container{
    display: flex;
    text-align: center; 
     padding: 60px 20px;
     justify-content: center;
     gap: 19px;
     flex-wrap:wrap ;

 }

.card h3{font-size: 1.5rem;
    margin-bottom: 15px;
    color: #2a5298;

  }
  .card{
    background-color: #ff9966;
    border-radius:12px;
    padding: 30px;
    width: 300px;
    box-shadow:0 8px 20px rgba(0, 0, 0, 0.1) ;
    transition: transform o.3 ease;
  } 
  .card:hover{
    transform: translateY(-10px);
  }
  .card p{
    color: #f5efef;
    font-size: 19px;
  }
.hero2{
  display: flex;
    text-align: center; 
     padding: 60px 20px;
     justify-content: center;
     gap: 19px;
     flex-wrap: wrap;

}
.skill{
    font-family: "Roboto","sans-serif";
    margin-bottom: 0;
}
.skill h3{
    font-size: 2.5rem;
    font-weight: 900;


}
.card-skill h3 {
    justify-content: center;
    color:  #2a5298;
    font-size: 17px;
    font-weight:700 ;
    margin-bottom: 5px;
}
.card-skill p{
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
}
.card-skill {
    background-color: #ff9966;
    border-radius:12px;
    padding: 30px;
    width: 300px;
    box-shadow:0 8px 20px rgba(0, 0, 0, 0.1) ;
    transition: transform o.3 ease;
}
.card-skill:hover{
    transform: translateY(-10px);
}
.hero3 h2{
    font-family: "Roboto","sans-serif";
    font-size: 49px;
    font-weight: 1000;

}

.hero4 {
   color: #2a5298;
   font-size: 33px;
   font-weight: 800;
   margin-bottom: 13px;
}
.hero5{
    display: flex;
    justify-content: center;
     text-align: center; 
     padding: 60px 20px;
     gap: 20px;
}
.Impact h2{
    color: #2a5298;
    font-family: "roboto","sans-serif";
    margin-bottom: 2px;

}
.Impact p{
    font-size: 20px;
}
.hero6 h3{
    font-size: 39px;
    font-family: "roboto","sans-serif";
    color: #f5efef;
    font-weight: 900;
    text-align: center;
}
.hero6 p{
    font-size: 25px;
    font-family: "roboto","sans-serif";
    font-weight: bold;
    margin-top: 20px;
}
.btn{
    text-align: center;
    background-color: #fceabb;
    border-radius: 38px;
    text-decoration: none;
    padding: 4px;
    color: #000000;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 300px;
    height: 50px;
    margin: 20px auto;
    cursor: pointer;
    font-weight: 900;
    font-family: "roboto","sans-serif";

}
.final{
    background:linear-gradient(to right,#2a5298, #1e3c72);
    width: 100%;
    height: calc(100vh-100px);
    display: flex;
    justify-content: center;
    align-items: center;
    

}
.btn:hover{
     background-color: #363111;
    color: #ffffff;
    box-shadow: 0 0 10px #fceabb, 0 0 20px #fceabb ;
    transform: all 0,3s ease;
}

.hero6{
    max-width:600px ;
    
}
.footer{
    background-color: #071838;
    width: 100%;
    height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.footer h2{
    display: flex;
    justify-content: center;
    margin-bottom: 5px;
    color: #1369fd;
}
.footer p{
    display: flex;
    color: #f5efef;
     justify-content: center;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Roboto", sans-serif;
    background-color: #0e1525;
    color: #f5f5f5;
}
.hero1 {
    background: linear-gradient(to right, #FFDEE9, #B5FFFC);
    padding: 100px 20px;
    text-align: center;
    color: #1e3c72;
}

.hero1 h1 {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 20px;
}

.hero1 p {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 10px;
}

/* Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    position: fixed;
    width: 100%;
    height: 60px;
    top: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0), #1e3c72);
    z-index: 1000;
}

.size-6 {
    width: 21px;
}

.youth-logo {
    color: #FF5E62;
    height: 40px;
    font-weight: 700;
}

.navbar ul {
    display: flex;
    list-style: none;
    font-size: 18px;
    gap: 20px;
}

.navbar a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 600;
}

.red {
    color: #1e3c72;
    font-size: 1.7rem;
    font-weight: 900;
}

/* Hero Section */
.hero {
    height: 100vh;
    background: linear-gradient(to right, #00C9FF, #92FE9D);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 2rem;
    margin-bottom: 60px;
}

.hero h1 {
    display: flex;
    font-size: 5rem;
    margin-bottom: 1rem;
    color: #ffffff;
    font-weight: 900;
    justify-content: center;
}

.hero h5 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 20px;
    max-width: 600px;
    margin-bottom: 2rem;
}

/* Buttons */
.btn-primary {
    background-color: #FF5E62;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 15px;
    font-weight: 700;
    height: 40px;
    width: 200px;
    border-radius: 16px;
    color: #fff;
    border: none;
    transition: background-color 0.3s, color 0.3s;
}

.btn-primary:hover {
    background-color: #FFC107;
    color: #000;
}

.btn-secondary {
    background-color: #ffffff;
    height: 40px;
    width: 200px;
    font-size: 16px;
    font-weight: 900;
    display: flex;
    justify-content: center;
    align-items: center;
    border: none;
    border-radius: 16px;
    color: #000;
    transition: background-color 0.3s, color 0.3s;
}

.btn-secondary:hover {
    background-color: #333;
    color: #fff;
}

.btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}

/* Cards Section */
.cards-container, .hero2 {
    display: flex;
    text-align: center;
    padding: 60px 20px;
    justify-content: center;
    gap: 19px;
    flex-wrap: wrap;
}

.card, .card-skill {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 30px;
    width: 300px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, background 0.3s ease;
}

.card:hover, .card-skill:hover {
    transform: translateY(-10px);
    background: linear-gradient(to right, #FFDEE9, #B5FFFC);
}

.card h3, .card-skill h3 {
    color: #2a5298;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.card p, .card-skill p {
    color: #555;
    font-size: 18px;
    font-weight: 600;
}

.skill h3 {
    font-size: 2.5rem;
    font-weight: 900;
}

/* Hero3, Hero4, Hero5 Sections */
.hero3 h2 {
    font-size: 49px;
    font-weight: 1000;
    text-align: center;
    margin: 60px 0 20px;
}

.hero4 {
    color: #2a5298;
    font-size: 33px;
    font-weight: 800;
    margin-bottom: 13px;
}

.hero5 {
    display: flex;
    justify-content: center;
    text-align: center;
    padding: 60px 20px;
    gap: 20px;
}

.Impact h2 {
    color: #2a5298;
    margin-bottom: 10px;
}

.Impact p {
    font-size: 20px;
}

/* Final Section */
.final {
    background: linear-gradient(to right, #2a5298, #1e3c72);
    width: 100%;
    padding: 80px 20px;
    text-align: center;
    color: #fff;
}

.hero6 {
    max-width: 600px;
    margin: auto;
}

.hero6 h3 {
    font-size: 39px;
    font-weight: 900;
    margin-bottom: 20px;
}

.hero6 p {
    font-size: 25px;
    font-weight: bold;
    margin-bottom: 30px;
}

.btn {
    background-color: #FFC107;
    border-radius: 38px;
    text-decoration: none;
    padding: 10px;
    color: #000000;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 300px;
    height: 50px;
    margin: 0 auto;
    cursor: pointer;
    font-weight: 900;
    transition: all 0.3s ease;
}

.btn:hover {
    background-color: #363111;
    color: #ffffff;
    box-shadow: 0 0 10px #fceabb, 0 0 20px #fceabb;
}

/* Footer */
.footer {
    background-color: #0D1B2A;
    width: 100%;
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    text-align: center;
}

.footer h2 {
    color: #FFC107;
    font-size: 20px;
}

.footer p {
    color: #f5f5f5;
    font-size: 16px;
}
