import { Component, OnInit } from '@angular/core';
import { Http, Headers, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import { Router } from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  email : string = "";
  password : string = "";

  constructor(private http:Http, private router:Router) { }

  ngOnInit() {
  }

  logIn(){
    var body = JSON.stringify({
      "email" : this.email,
      "password" : this.password
    });
    var hdr = new Headers({ "Content-Type" : "application/json"});
    var options = new RequestOptions({ headers : hdr})
    this.http.post('http://localhost:8000/api/user/signin', body, options)
    .subscribe(
      result => {
        sessionStorage.setItem("token",result.json().token);
        // localStorage.setItem("","")
        this.router.navigate(['/']);
        
        console.log(result.json().token);
      },
      error => {

      }
    );
  }

}
