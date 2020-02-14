@extends('principal')
@section('contenido')

 @if(Auth::check())
            @if (Auth::user()->idrol == 1)
               
            <template v-if="menu==0">
            <dashboard></dashboard>
            </template>

            <template v-if="menu==1">
              <categoria></categoria>
            </template>

            <template v-if="menu==2">
              <producto></producto>
            </template>

            <template v-if="menu==3">
              <compra></compra>
            </template>

            <template v-if="menu==4">
                <proveedor></proveedor>
            </template>

              <template v-if="menu==5">
              <venta></venta>
            </template>

            <template v-if="menu==6">
              <cliente></cliente>
            </template>

            <template v-if="menu==7">
              <user></user>
            </template>

            <template v-if="menu==8">
              <rol></rol>
            </template>

            <template v-if="menu==9">
              <dashboarddetalle></dashboarddetalle>
            </template>

            <template v-if="menu==10">
              <banco></banco> 
            </template>

            <template v-if="menu==11">
                 <tarjeta></tarjeta>
            </template>
            
            

            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0">
            <dashboard></dashboard>
            </template>

            <template v-if="menu==1">
              <categoria></categoria>
            </template>

            <template v-if="menu==2">
              <producto></producto>
            </template>

            <template v-if="menu==5">
              <venta></venta>
            </template>

            <template v-if="menu==6">
              <cliente></cliente>
            </template>

            <template v-if="menu==9">
            <dashboarddetalle></dashboarddetalle>
            </template>

            <template v-if="menu==10">
              <banco></banco> 
            </template>

            <template v-if="menu==11">
                <tarjeta></tarjeta>
            </template>

            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0">
            <dashboard></dashboard>
            </template>

            <template v-if="menu==1">
            <categoria></categoria>
            </template>

            <template v-if="menu==2">
            <producto></producto>
            </template>

            <template v-if="menu==3">
             <compra></compra>
            </template>

            <template v-if="menu==4">
              <proveedor></proveedor>
            </template>
            @else

            @endif

@endif
 


@endsection