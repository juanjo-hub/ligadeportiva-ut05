import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';
import { JugadoresComponent } from './jugadores.component';
import { environment } from '../../../environments/environment';

describe('JugadoresComponent', () => {
  let component: JugadoresComponent;
  let fixture: ComponentFixture<JugadoresComponent>;
  let httpMock: HttpTestingController;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [JugadoresComponent, HttpClientTestingModule]
    }).compileComponents();

    fixture = TestBed.createComponent(JugadoresComponent);
    component = fixture.componentInstance;
    httpMock = TestBed.inject(HttpTestingController);
    fixture.detectChanges();
  });

  afterEach(() => {
    httpMock.verify();
  });

  it('debería crearse el componente', () => {
    expect(component).toBeTruthy();
  });

  it('debería cargar jugadores desde la API al iniciar', () => {
    const mockJugadores = [
      { id: 1, nombre: 'Juan Pérez', posicion: 'Delantero', dorsal: 9, club_id: 1,
        club: { id: 1, nombre: 'CD Maestre', ciudad: 'Bolaños', categoria: 'Senior' } },
      { id: 2, nombre: 'Ana García', posicion: 'Portero', dorsal: 1, club_id: 1,
        club: { id: 1, nombre: 'CD Maestre', ciudad: 'Bolaños', categoria: 'Senior' } }
    ];

    const req = httpMock.expectOne(`${environment.apiUrlLaravel}/jugadors`);
    expect(req.request.method).toBe('GET');
    req.flush(mockJugadores);

    expect(component.jugadores.length).toBe(2);
    expect(component.cargando).toBeFalse();
  });

  it('debería gestionar un error de la API', () => {
    const req = httpMock.expectOne(`${environment.apiUrlLaravel}/jugadors`);
    req.flush('Error', { status: 500, statusText: 'Server Error' });
    expect(component.error).not.toBeNull();
  });
});
