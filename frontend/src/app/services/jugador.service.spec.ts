import { TestBed } from '@angular/core/testing';
import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';
import { JugadorService, Jugador } from './jugador.service';
import { environment } from '../../environments/environment';

describe('JugadorService', () => {
  let service: JugadorService;
  let httpMock: HttpTestingController;

  const mockJugadores: Jugador[] = [
    { id: 1, nombre: 'Juan Pérez', posicion: 'Delantero', dorsal: 9, club_id: 1,
      club: { id: 1, nombre: 'CD Maestre', ciudad: 'Bolaños', categoria: 'Senior' } },
    { id: 2, nombre: 'Ana García', posicion: 'Portero', dorsal: 1, club_id: 2,
      club: { id: 2, nombre: 'Atlético Calatrava', ciudad: 'Calatrava', categoria: 'Junior' } }
  ];

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule],
      providers: [JugadorService]
    });
    service = TestBed.inject(JugadorService);
    httpMock = TestBed.inject(HttpTestingController);
  });

  afterEach(() => {
    httpMock.verify();
  });

  it('debería crearse el servicio', () => {
    expect(service).toBeTruthy();
  });

  it('debería obtener la lista de jugadores (mock HTTP)', () => {
    service.obtenerJugadores().subscribe(jugadores => {
      expect(jugadores.length).toBe(2);
      expect(jugadores[0].nombre).toBe('Juan Pérez');
    });
    const req = httpMock.expectOne(`${environment.apiUrlLaravel}/jugadors`);
    expect(req.request.method).toBe('GET');
    req.flush(mockJugadores);
  });

  it('debería obtener un jugador por id', () => {
    service.obtenerJugador(1).subscribe(jugador => {
      expect(jugador.id).toBe(1);
    });
    const req = httpMock.expectOne(`${environment.apiUrlLaravel}/jugadors/1`);
    expect(req.request.method).toBe('GET');
    req.flush(mockJugadores[0]);
  });

  it('debería crear un jugador', () => {
    const nuevo: Partial<Jugador> = { nombre: 'Nuevo', posicion: 'Defensa', dorsal: 5, club_id: 1 };
    service.crearJugador(nuevo).subscribe(jugador => {
      expect(jugador.nombre).toBe('Nuevo');
    });
    const req = httpMock.expectOne(`${environment.apiUrlLaravel}/jugadors`);
    expect(req.request.method).toBe('POST');
    req.flush({ id: 3, ...nuevo });
  });
});
