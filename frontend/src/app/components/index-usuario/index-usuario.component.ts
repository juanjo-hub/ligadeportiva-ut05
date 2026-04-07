import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-index-usuario',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './index-usuario.component.html'
})
export class IndexUsuarioComponent implements OnInit {

  partidos: any[] = [];
  equipoUsuario = '';

  apiUrl = environment.apiUrlNode;

  constructor(private http: HttpClient) {}

  ngOnInit() {
    const usuario = JSON.parse(localStorage.getItem('usuario') || '{}');

    this.equipoUsuario = usuario.equipo;

    if (!this.equipoUsuario) {
      return;
    }

    this.http.get<any>(`${this.apiUrl}/partidos/equipo/${this.equipoUsuario}`)
      .subscribe(res => {
        this.partidos = res.partidos;
      });
  }
}

