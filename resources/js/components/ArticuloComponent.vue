<template>
  <div>
    <hr />
    <div class="row">
      <div class="col">
        <button
          type="button"
          v-on:click="consultarCategorias()"
          data-toggle="modal"
          data-target="#modalCreate"
          class="btn btn-success"
        >Agregar Articulo</button>
      </div>
      <div class="col">
        <p></p>
      </div>
      <div class="col">
        <input
          type="search"
          name="buscar"
          v-on:keyup="consultar()"
          v-model="valorBuscar"
          class="form-control"
          placeholder="Buscar..."
        />
      </div>
    </div>
    <hr />

    <h1>Administración de Artículos</h1>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Codigo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Precio</th>
          <th scope="col">Stock</th>
          <th scope="col">Descripción</th>
          <th scope="col">Estado</th>
          <th scope="col">Categoria</th>
          <th scope="col">Editar</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in datos" :key="item.id">
          <th v-text="item.codigo"></th>
          <th v-text="item.nombre"></th>
          <th v-text="item.precio_venta"></th>
          <th v-text="item.stock"></th>
          <td v-text="item.descripcion"></td>
          <td>
            <div v-if="item.condicion">
              <span class="badge badge-success">Activo</span>
            </div>
            <div v-else>
              <span class="badge badge-danger">Desactivado</span>
            </div>
          </td>
          <td v-text="item.nombre_categoria"></td>
          <td>
            <button class="btn btn-info" v-on:click="abrirModalEditar(item)">Editar</button>
          </td>

          <td>
            <div v-if="item.condicion==1">
              <button class="btn btn-danger" v-on:click="abrirModalConfirmar(item)">Eliminiar</button>
            </div>
            <div v-if="item.condicion==0">
              <button class="btn btn-primary" v-on:click="activar(item)">Activar</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <hr />
    <!-- fin tabla -->

    <!-- paginacion  -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-if="paginate.current_page > 1">
          <button
            class="page-link"
            href="#"
            @click.prevent="changePage(paginate.current_page-1)"
          >Previous</button>
        </li>

        <li
          class="page-item"
          v-for="page in pagesNumber"
          :key="page"
          v-bind:class="[page == isActivo ? 'active':'' ]"
        >
          <button class="page-link" @click.prevent="changePage(page)">{{page}}</button>
        </li>

        <li class="page-item" v-if="paginate.current_page < paginate.last_page">
          <button
            class="page-link"
            href="#"
            @click.prevent="changePage(paginate.current_page+1)"
          >Next</button>
        </li>
      </ul>
    </nav>
    <!-- fin paginacion -->

    <!-- Modal nuevo -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nuevo Articulo</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Categoria</label>
                <select class="form-control" v-model="categoria_id">
                  <option value="0">Seleccionar...</option>
                  <option
                    v-for="item in listaCategorias"
                    :key="item.id"
                    v-bind:value="item.id"
                  >{{item.nombre}}</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Código:</label>
                <input
                  type="number"
                  v-model="codigo"
                  class="form-control"
                  placeholder="Código de barras"
                />
                <span v-if="errores.codigo" class="error">{{errores.codigo[0]}}</span>
                <!-- <barcode :value="codigo" :options="{ format :'EAN-13'}"></barcode> -->
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input
                  type="text"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                  max="100"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Precio:</label>
                <input
                  type="number"
                  v-model="precio_venta"
                  class="form-control"
                  placeholder="Precio"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Stock:</label>
                <input type="number" v-model="stock" class="form-control" placeholder="stock" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Descripción:</label>
                <input
                  type="text"
                  v-model="descripcion"
                  class="form-control"
                  placeholder="Descripcion"
                  max="256"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                data-dismiss="modal"
                v-on:click="cancelar()"
                class="btn btn-secondary"
              >Cancelar</button>

              <button
                type="button"
                id="Agregar"
                :disabled="isDisabled"
                v-on:click="create()"
                class="btn btn-success"
              >Agregar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--fin Modal nuevo / editar cliente -->

    <!-- Modal editar -->
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Actualizar Articulo</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Categoria</label>
                <select class="form-control" v-model="categoria_id">
                  <option value="0">Seleccionar...</option>
                  <option
                    v-for="item in listaCategorias"
                    :key="item.id"
                    v-bind:value="item.id"
                  >{{item.nombre}}</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Código:</label>
                <input
                  type="number"
                  v-model="codigo"
                  class="form-control"
                  placeholder="Código de barras"
                />
                <!-- <barcode :value="codigo" :options="{ format :'EAN-13'}"></barcode> -->
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input
                  type="text"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                  max="100"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Precio:</label>
                <input
                  type="number"
                  v-model="precio_venta"
                  class="form-control"
                  placeholder="Precio"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Stock:</label>
                <input type="number" v-model="stock" class="form-control" placeholder="stock" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Descripción:</label>
                <input
                  type="text"
                  v-model="descripcion"
                  class="form-control"
                  placeholder="Descripcion"
                  max="256"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                data-dismiss="modal"
                v-on:click="cancelar()"
                class="btn btn-secondary"
              >Cancelar</button>

              <button
                type="button"
                id="Agregar"
                :disabled="isDisabled"
                v-on:click="update()"
                class="btn btn-success"
              >Actualizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--fin Modal editar -->

    <!-- ModalConfirmarCancelar -->
    <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="max-width: 600px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1>Realmente quiere borrarlo?</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              v-on:click="cancelar()"
              class="btn btn-secondary"
            >Cancelar</button>
            <button
              type="button"
              id="btnConfirmarBorrado"
              v-on:click="borrar()"
              class="btn btn-success"
            >Confirmar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueBarcode from "vue-barcode";

export default {
  data() {
    return {
      id: "",
      codigo: 0,
      nombre: "",
      precio_venta: 0,
      stock: 0,
      descripcion: "",
      condicion: "",
      categoria_id: 0,
      datos: [],
      listaCategorias: [],
      valorBuscar: "",
      errores: "",
      //propiedad de la paginacion
      paginate: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      }
    };
  },
  components: {
    barcode: VueBarcode
  },
  methods: {
    consultar(page) {
      var url = "/articulo?page=" + page + "&buscar=" + this.valorBuscar;
      axios
        .get(url)
        .then(
          response => (
            (this.datos = response.data.articulos.data),
            (this.paginate = response.data.paginate)
          )
        );
    },

    consultarCategorias() {
      axios
        .get("/categorialistar")
        .then(response => (this.listaCategorias = response.data));
    },

    create() {
      axios
        .post("/articulo", {
          codigo: this.codigo,
          nombre: this.nombre,
          precio_venta: this.precio_venta,
          stock: this.stock,
          descripcion: this.descripcion,
          categoria_id: this.categoria_id
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errores = error.response.data.errors;
          }
        });

      if (this.errores.length != 0) {
        //cerrar todo
        this.cancelar();

        //realizar nuevamente la consulta
        this.consultar();
      }
    },

    update() {
      axios
        .put("/articulo/" + this.id, {
          id: this.id,
          codigo: this.codigo,
          nombre: this.nombre,
          precio_venta: this.precio_venta,
          stock: this.stock,
          descripcion: this.descripcion,
          categoria_id: this.categoria_id
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      //llamar al metodo cancelar
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    borrar() {
      axios
        .delete("/articulo/" + this.id, { params: { id: this.id } })
        .then(response => console.log(response.data));

      //llamar al metodo cancelar
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    //abrir modal confirmar
    abrirModalConfirmar(articulo) {
      this.id = articulo.id;
      $("#ModalConfirmarBorrar").modal("show");
    },

    activar(objeto) {
      this.id = objeto.id;
      this.borrar();
    },

    cancelar() {
      //colocar valores en blanco
      this.id = "";
      this.codigo = "";
      this.nombre = "";
      this.precio_venta = 0;
      this.stock = 0;
      this.descripcion = "";
      this.categoria_id = 0;
      this.errores = [];

      //cerrar los modales
      $("#modalCreate").modal("hide");
      $("#modalUpdate").modal("hide");
      $("#ModalConfirmarBorrar").modal("hide");
    },

    abrirModalEditar(articulo) {
      //colocar valores
      this.id = articulo.id;
      this.codigo = articulo.codigo;
      this.nombre = articulo.nombre;
      this.precio_venta = articulo.precio_venta;
      this.stock = articulo.stock;
      this.descripcion = articulo.descripcion;
      this.categoria_id = articulo.categoria_id;

      //realizar peticion de categorias
      this.consultarCategorias();

      //mostrar modal
      $("#modalUpdate").modal("show");
    },

    //metodo de la paginacion
    changePage: function(page) {
      this.paginate.current_page = page;
      this.consultar(page);
    }
  },

  computed: {
    //realizar validaciones
    isDisabled: function() {
      if (this.nombre == "" || this.categoria_id == 0) {
        return true;
      } else {
        return false;
      }
    },

    //metodo de la paginacion
    isActivo: function() {
      return this.paginate.current_page;
    },
    //metodo de la paginacion
    pagesNumber: function() {
      if (!this.paginate.to) {
        return [];
      }
      var from = this.paginate.current_page - 2;
      if (from < 1) {
        from = 1;
      }

      var to = from + 2 * 2;
      if (to >= this.paginate.last_page) {
        to = this.paginate.last_page;
      }

      var pagesArray = [];

      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    }
  },

  mounted() {
    //realizar las consultas al cargar el componente
    this.consultar("");
  }
};
</script>


