import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

export interface Club {
  id: number;
  nombre: string;
  ciudad: string;
  categoria: string;
}

export interface Jugador {
  id: number;
  nombre: string;
  posicion: string;
  dorsal: number;
  club_id: number;
  club?: Club;
  created_at?: string;
  updated_at?: string;
}

@Injectable({
  providedIn: 'root'
})
export class JugadorService {

  // Este servicio consume el backend LARAVEL (UT3/UT4)
  private apiUrl = `${environment.apiUrlLaravel}/jugadors`;

  constructor(private http: HttpClient) {}

  obtenerJugadores(): Observable<Jugador[]> {
    return this.http.get<Jugador[]>(this.apiUrl);
  }

  obtenerJugador(id: number): Observable<Jugador> {
    return this.http.get<Jugador>(`${this.apiUrl}/${id}`);
  }

  crearJugador(jugador: Partial<Jugador>): Observable<Jugador> {
    return this.http.post<Jugador>(this.apiUrl, jugador);
  }

  actualizarJugador(id: number, jugador: Partial<Jugador>): Observable<Jugador> {
    return this.http.put<Jugador>(`${this.apiUrl}/${id}`, jugador);
  }

  eliminarJugador(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
