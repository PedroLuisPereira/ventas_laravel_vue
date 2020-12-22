@extends('layouts.app')

@section('menu')
    <ul class="navbar-nav mr-auto">

            {{-- menu para el administrador --}}
            @if (Auth::user()->rol_id==1)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Almacen</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=1" href="#">Categorias </a>
                        <a class="dropdown-item" v-on:click ="menu=2" href="#">Articulos</a>
                    </div>
                </li>                

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compras</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=3" href="#">Compras</a>
                        <a class="dropdown-item" v-on:click ="menu=4" href="#">Proveedores</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ventas</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=5" href="#">Ventas</a>
                        <a class="dropdown-item" v-on:click ="menu=6" href="#">Clientes</a>
                    </div>
                </li>
        
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acceso</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=7" href="#">Usuarios</a>
                        <a class="dropdown-item" v-on:click ="menu=8" href="#">Roles</a>
                    </div>
                </li>
    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=1" href="#">Categorias </a>
                        <a class="dropdown-item" v-on:click ="menu=2" href="#">Articulos</a>
                    </div>
                </li>
                
            @endif

            {{-- menú para el vendedor  --}}
            @if (Auth::user()->rol_id==2)

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ventas</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=5" href="#">Ventas</a>
                        <a class="dropdown-item" v-on:click ="menu=6" href="#">Clientes</a>
                    </div>
                 </li>

                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" v-on:click ="menu=1" href="#">Categorias </a>
                    <a class="dropdown-item" v-on:click ="menu=2" href="#">Articulos</a>
                    </div>
                </li>
                
            @endif

            {{-- menu para el almacenista --}}
            @if (Auth::user()->rol_id==3)

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Almacen</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=1" href="#">Categorias </a>
                        <a class="dropdown-item" v-on:click ="menu=2" href="#">Articulos</a>
                    </div>
                </li>                

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compras</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" v-on:click ="menu=3" href="#">Compras</a>
                        <a class="dropdown-item" v-on:click ="menu=4" href="#">Proveedores</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" v-on:click ="menu=1" href="#">Categorias </a>
                    <a class="dropdown-item" v-on:click ="menu=2" href="#">Articulos</a>
                    </div>
                </li>
                
            @endif

    </ul>

@endsection

@section('content')

            @if (Auth::user()->rol_id==1)

                    <template v-if = "menu == 0"  >
                        <h1>menu 0</h1>
                    </template>

                    <template v-if = "menu == 1"  >
                        <categoria-component></categoria-component>
                    </template>

                    <template v-if = "menu == 2"  >
                        <articulo-component></articulo-component>
                    </template>

                    <template v-if = "menu == 3"  >
                        <compra-component></compra-component>
                    </template>

                    <template v-if = "menu == 4"  >
                        <proveedor-component></proveedor-component>
                    </template>

                    <template v-if = "menu == 5"  >
                        <venta-component></venta-component>
                    </template>

                    <template v-if = "menu == 6"  >
                        <persona-component></persona-component>
                    </template>

                    <template v-if = "menu == 7"  >
                    <user-component></user-component>
                    </template>

                    <template v-if = "menu == 8"  >
                        <rol-component></rol-component>
                    </template>


            @endif

            @if (Auth::user()->rol_id==2)
                    <template v-if = "menu == 0"  >
                        <h1>menu 0</h1>
                    </template>
                    
                    <template v-if = "menu == 5"  >
                        <venta-component></venta-component>
                    </template>

                    <template v-if = "menu == 6"  >
                        <persona-component></persona-component>
                    </template>
            @endif

            @if (Auth::user()->rol_id==3)
                    <template v-if = "menu == 0"  >
                        <h1>menu 0</h1>
                    </template>

                    <template v-if = "menu == 1"  >
                        <categoria-component></categoria-component>
                    </template>

                    <template v-if = "menu == 2"  >
                        <articulo-component></articulo-component>
                    </template>

                    <template v-if = "menu == 3"  >
                        <compra-component></compra-component>
                    </template>

                    <template v-if = "menu == 4"  >
                        <proveedor-component></proveedor-component>
                    </template>
                    
            @endif
      
@endsection

