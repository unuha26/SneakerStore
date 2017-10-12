import { Component, OnInit } from '@angular/core';
import { Http, Headers, RequestOptions } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import { Router } from "@angular/router";
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.css']
})
export class ProductComponent implements OnInit {
  file : FileList;
  product_id : number = 0;

  constructor(private http:Http, private route:ActivatedRoute, private router:Router) { }

  ngOnInit() {
    this.route.params.subscribe(params=>{
      this.product_id = params['product_id'];
      console.log(this.product_id);
    });
  }

  fileChange(event){
    this.file = event.target.files;
    console.log(this.file)
  }
  upload(){
    if(this.file.length > 0){
      var myFile : File = this.file[0];
      var formData : FormData = new FormData();
      formData.append('image', myFile);
      formData.append('product_id', '1');

      var hd = new Headers();
      var options = new RequestOptions({ headers : hd });
      this.http.post('http://localhost:8000/api/product/saveproductimage', formData, options)
      .subscribe(
        result => {},
        error => {}
      );
    }
  }
  redirectToProduct(){
    var productId = 1;
    this.router.navigate(['/product', productId]);
  }

}
