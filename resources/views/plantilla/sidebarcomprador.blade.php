<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Dashbord</a>
                    </li>
                    <li class="nav-title">
                        Menú
                    </li>

                   
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list"></i> Categorías</a>
                    </li>
                    
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-tasks"></i> Productos</a>
                    </li>
                      
            
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-shopping-cart"></i> Compras</a>
                    </li>

                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-users"></i> Proveedores</a>
                    </li>
            
                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>