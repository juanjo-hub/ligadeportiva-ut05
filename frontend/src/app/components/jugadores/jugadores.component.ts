import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { JugadorService, Jugador } from '../../services/jugador.service';

@Component({
  selector: 'app-jugadores',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './jugadores.component.html',
  styleUrls: ['./jugadores.component.css']
})
export class JugadoresComponent implements OnInit {

  jugadores: Jugador[] = [];
  cargando = true;
  error: string | null = null;

  filtroNombre = '';
  filtroPosicion = 'all';
  filtroClub = 'all';

  constructor(private jugadorService: JugadorService) {}

  ngOnInit(): void {
    this.cargarJugadores();
  }

  cargarJugadores(): void {
    this.cargando = true;
    this.error = null;

    this.jugadorService.obtenerJugadores().subscribe({
      next: (data) => {
        this.jugadores = data || [];
        this.cargando = false;
      },
      error: (err) => {
        console.error('Error al cargar jugadores', err);
        this.error = 'No se pudieron cargar los jugadores. Comprueba que el backend Laravel está disponible.';
        this.cargando = false;
      }
    });
  }

  get jugadoresFiltrados(): Jugador[] {
    return this.jugadores.filter(j => {
      if (this.filtroNombre &&
          !j.nombre.toLowerCase().includes(this.filtroNombre.toLowerCase())) return false;
      if (this.filtroPosicion !== 'all' &&
          j.posicion.toLowerCase() !== this.filtroPosicion.toLowerCase()) return false;
      if (this.filtroClub !== 'all' && j.club?.nombre !== this.filtroClub) return false;
      return true;
    });
  }

  get clubesUnicos(): string[] {
    const nombres = this.jugadores.map(j => j.club?.nombre).filter((n): n is string => !!n);
    return Array.from(new Set(nombres)).sort();
  }

  get posicionesUnicas(): string[] {
    return Array.from(new Set(this.jugadores.map(j => j.posicion))).sort();
  }
}
