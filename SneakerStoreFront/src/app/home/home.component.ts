import { Component, OnInit } from '@angular/core';
import { Http, Headers, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Rx';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  productList :object[] = [];

  constructor( private http:Http) { }

  ngOnInit() {
    var token = sessionStorage.getItem("token");
    console.log("token " + token);
    var hdr = new Headers({"Authorization" : "Bearer" + token});
    var options = new RequestOptions({headers:hdr});
    this.http.get("http://localhost:8000/api/product/getallproduct", options)
    .subscribe(
      result => {
        this.productList = result.json();
        console.log(this.productList);
      },
      error =>{

      }
    );
  }

}
