import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  // Login y register usan el backend Node + MongoDB
  private apiUrl = environment.apiUrlNode;

  constructor(private http: HttpClient) {}

  login(usuario: string, password: string): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/login`, {
      params: { usuario, password }
    });
  }

  register(usuario: string, password: string, tipo: string, equipo?: string) {
    return this.http.post<any>(`${this.apiUrl}/register`, {
      usuario,
      password,
      tipo,
      equipo
    });
  }
}
