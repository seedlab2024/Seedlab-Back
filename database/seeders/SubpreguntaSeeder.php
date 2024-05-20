<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subpreguntas;

class SubpreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preguntasPorSubpreguntas = [
            '2' => [
                '1' => ['texto' => 'Administrativo',
                        'puntaje' => '2.0'],
                '2' => ['texto' => 'Desarrollo',
                'puntaje' => '5.0'],
                '3' => ['texto' => 'Producción',
                'puntaje' => '5.0'],
                '4' => ['texto' => 'Innovacion y/o desarrollo',
                        'puntaje' => '5.0'],
                '5' => ['texto' => 'Comercialización',
                        'puntaje' => '5.0'],
                '6' => ['texto' => 'Otro, cuál / cuántos?',
                'puntaje' => '0'],
            ],
            '12'=>[
                '7'=>['texto' => 'Meta 1', //no tienen importancia
                    'puntaje' => '0'],
                '8'=>['texto' => 'Meta 2',
                    'puntaje' => '0'],
                '9'=>['texto' => 'Meta 3',
                    'puntaje' => '0'],
                '10'=>['texto' => 'Meta 4',
                    'puntaje' => '0'],
            ],
            '17'=>[
                '11'=>['texto' => 'Gastos fijos', //por definir porque tiene si no y medio
                    'puntaje' => '0'],
                '12'=>['texto' => 'Gastos variables', 
                    'puntaje' => '0'],
                '13'=>['texto' => 'Gastos operacionales', 
                    'puntaje' => '0'],
                '14'=>['texto' => 'Gastos no operacionales', 
                    'puntaje' => '0'],
                '15'=>['texto' => 'Costos fijos', 
                    'puntaje' => '0'],
                '16'=>['texto' => 'Costos variables', 
                    'puntaje' => '0'],
                '17'=>['texto' => 'Costos directos', 
                    'puntaje' => '0'],
                '18'=>['texto' => 'Costos indirectos', //por definir porque tiene si no y medio
                'puntaje' => '0'],
            ],
            '19'=>[
                '19'=>['texto' => 'Balance general',//por definir porque tiene si no y medio
                    'puntaje' => '0'],
                '20'=>['texto' => 'Estado de flujo',
                    'puntaje' => '0'],
                '21'=>['texto' => 'Registro de compras',
                    'puntaje' => '0'],
                '22'=>['texto' => 'Registro de ventas',
                    'puntaje' => '0'],
                '23'=>['texto' => 'Otro ¿Cual?',//por definir porque tiene si no y medio
                    'puntaje' => '0'],
              
            ],
            '21'=>[
                '24'=>['texto' => 'Ingreso', //por definir porque tiene si no y medio
                    'puntaje' => '0'],
                '25'=>['texto' => 'Egreso',
                    'puntaje' => '0'],
                '26'=>['texto' => 'Deudas',
                    'puntaje' => '0'],
                '27'=>['texto' => 'Otro ¿Cual?', //por definir porque tiene si no y medio
                    'puntaje' => '0'],
            ],
            '23'=>[
                '28'=>['texto' => 'Costos', //por definir porque tiene si no y medio
                    'puntaje' => '0'],
                '29'=>['texto' => 'Demanda',
                    'puntaje' => '0'],
                '30'=>['texto' => 'Competencia',
                    'puntaje' => '0'],
                '31'=>['texto' => 'Otro ¿Cual?', //por definir porque tiene si no y medio
                    'puntaje' => '0'],
            ],
            '24'=>[
                '32'=>['texto' => 'Prestamo formal',
                    'puntaje' => '2.5'],
                '33'=>['texto' => 'Prestamo informal',
                    'puntaje' => '1.5'],
                '34'=>['texto' => 'Disminuyendo gastos',
                    'puntaje' => '3.0'],
                '35'=>['texto' => 'Ahorros/propios',
                    'puntaje' => '3.0'],
                '36'=>['texto' => 'Otro ¿Cual?',
                    'puntaje' => '0'],
            ],
            '26'=>[
                '37'=>['texto' => 'Ingreso supperior al egreso',
                    'puntaje' => '15.0'],
                '38'=>['texto' => 'Ingreso superior al egreso',
                    'puntaje' => '10.0'],
                '39'=>['texto' => 'ingreso inferior al egreso',
                    'puntaje' => '5.0'],
                '40'=>['texto' => 'No sabe',
                    'puntaje' => '1.0'],
            ],
            '27'=>[
                '41'=>['texto' => 'Punto de venta',
                    'puntaje' => '2.5'],
                '42'=>['texto' => 'Telemarketing',
                    'puntaje' => '2.5'],
                '43'=>['texto' => 'Marketplace',
                    'puntaje' => '2.5'],
                '44'=>['texto' => 'Ecommerce',
                    'puntaje' => '2.5'],
                '45'=>['texto' => 'Otro ¿Cual?',
                    'puntaje' => '0'],
            ],
            '29'=>[
                '46'=>['texto' => 'Iva',
                    'puntaje' => '1.5'],
                '47'=>['texto' => 'Ica',
                    'puntaje' => '1.5'],
                '48'=>['texto' => 'Retefuente',
                    'puntaje' => '1.5'],
                '49'=>['texto' => 'Impuesto a la renta',
                    'puntaje' => '1.5'],
            ],
            '42'=>[
                '50'=>['texto' => '¿La propuesta cuenta con una identificación básica de información científica susceptible de ser aplicada?',
                    'puntaje' => '0.7'],
                '51'=>['texto' => '¿Tiene al menos una imagen general de lo que debe hacer su producto y/o servicio?',
                    'puntaje' => '0.7'],
                '52'=>['texto' => '¿Tiene claridad en las necesidades para el desarrollo de su producto y/o servicio?',
                    'puntaje' => '0.7'],
                '53'=>['texto' => '¿Se cuenta con un aparente diseño que dé solución a la oportunidad detectada?',
                    'puntaje' => '0.8'],
                '54'=>['texto' => '¿Los elementos básicos del producto y/o servicio se encuentran identificados?',
                    'puntaje' => '0.8'],
                '55'=>['texto' => '¿Se cuenta con experiencia en el desarrollo de producto y/o servicios similares?',
                    'puntaje' => '0.8'],
                '56'=>['texto' => '¿Tiene algún cliente interesado ya en dicho producto y/o servicio?',
                    'puntaje' => '0.8'],
                '57'=>['texto' => '¿Se tiene claro los requerimientos legales para la puesta en marcha del producto y o servicio propuesto?',
                    'puntaje' => '0.8'],
                '58'=>['texto' => '¿El producto y/o servicio resuelve la necesidad del mercado de manera sostenible?',
                    'puntaje' => '2.0'],
                '59'=>['texto' => '¿Se cuenta con un modelo/prototipo de simulación del producto y/o servicio?',
                    'puntaje' => '2.0'],
                '60'=>['texto' => '¿Se tienen estrategias de mitigación de riesgos identificados?',
                    'puntaje' => '2.0'],
                '61'=>['texto' => '¿Los diseños del producto y/o servicio ya se encuentra validados en entorno controlado?',
                    'puntaje' => '8.0'],
                '62'=>['texto' => '¿se conoce lo que se necesita para implementar producto y o servicio?',
                    'puntaje' => '3.3'],
                '63'=>['texto' => '¿El producto y/o servicio fue validado por un laboratorio y está validación es favorable adecuada?',
                    'puntaje' => '3.3'],
                '64'=>['texto' => '¿Los costos de la propuestas ya se encuentran analizados?',
                    'puntaje' => '3.3'],
                '65'=>['texto' => '¿Tiene definidos los proveedores de insumos y materiales para la ejecución del producto y/o servicio?',
                    'puntaje' => '4.0'],
                '66'=>['texto' => '¿Tiene definido criterios para la selección de proveedores?',
                    'puntaje' => '4.0'],
                '67'=>['texto' => '¿El producto esta validado a nivel de detalle?',
                    'puntaje' => '4.0'],
                '68'=>['texto' => '¿Han sido identificados los efectos adversos del producto y/o servicio?',
                    'puntaje' => '5.0'],
                '69'=>['texto' => '¿El producto y/o servicio ha sido validad en un entorno real?',
                    'puntaje' => '5.0'],
                '70'=>['texto' => '¿Producto y/o servicio ya esta lista para la producción?',
                    'puntaje' => '5.0'],
                '71'=>['texto' => '¿El producto y/o servicio cuenta con documentación de usuario, mantenimiento y de servicio especificadas y controladas?',
                    'puntaje' => '6.0'],
                '72'=>['texto' => '¿El producto y/o servicio esta validado, comprobado y acreditado completamente?',
                    'puntaje' => '6.0'],
                '73'=>['texto' => '¿El producto y/o servicio cuenta con una producción estable?',
                    'puntaje' => '6.0'],
                '74'=>['texto' => '¿Se tiene la capacidad para desarrollar el producto y/o servicio?',
                    'puntaje' => '3.6'],
                '75'=>['texto' => '¿Implementa planes de producción?',
                    'puntaje' => '3.6'],
                '76'=>['texto' => '¿Implementa planes de compra?',
                    'puntaje' => '3.6'],
                '77'=>['texto' => '¿El producto y/o servicio se encuentra implementado y funcionando?',
                    'puntaje' => '3.6'],
                '78'=>['texto' => '¿Tienen parámetros de calidad definidos para su producto y/o servicio?',
                    'puntaje' => '3.6'],
                '79'=>['texto' => '¿El producto y/o servicio cuenta con patente, propiedad intelectual y/o industrial registrada?',
                    'puntaje' => '3.6'],
                '80'=>['texto' => '¿El producto y/o servicio cuenta con certificados de calidad, ambientales, otros?',
                    'puntaje' => '3.6'],
            ],


            '45'=>[
                '81'=>['texto' => 'Apoyo tecnico',
                    'puntaje' => '5.8'],
                '82'=>['texto' => 'Capacitación',
                    'puntaje' => '5.8'],
                '83'=>['texto' => 'Financiamiento',
                    'puntaje' => '5.8'],
                '84'=>['texto' => 'Redes/alianza',
                    'puntaje' => '5.8'],
                '85'=>['texto' => 'Mejora de la calidad p/s',
                    'puntaje' => '5.8'],
                '86'=>['texto' => 'Infraestructura',
                    'puntaje' => '5.8'],
                '87'=>['texto' => 'Otro ¿Cual?',
                    'puntaje' => '0'],
            ],
            '47'=>[
                '88'=>['texto' => 'Apoyo tecnico',
                    'puntaje' => '6.9'],
                '89'=>['texto' => 'Capacitación',
                    'puntaje' => '6.9'],
                '90'=>['texto' => 'Financiamiento',
                    'puntaje' => '6.9'],
                '91'=>['texto' => 'Redes/alianza',
                    'puntaje' => '6.9'],
                '92'=>['texto' => 'Infraestructura',
                    'puntaje' => '6.9'],
                '93'=>['texto' => 'Aumento de clientes',
                    'puntaje' => '6.9'],
                '94'=>['texto' => 'Bajar costos y/o gastos',
                    'puntaje' => '6.9'],
                '95'=>['texto' => 'Mejorar ventas',
                    'puntaje' => '6.9'],
                '96'=>['texto' => 'Otro ¿Cual?',
                    'puntaje' => '0'],

            ]
        ];

        foreach($preguntasPorSubpreguntas as $idPregunta =>$preguntas ){
            foreach($preguntas as $nombrePregunta =>$contenido){
                Subpreguntas::create([
                    'texto' =>$contenido['texto'],
                    'puntaje' =>$contenido['puntaje'],
                    'id_pregunta' => $idPregunta
                ]);
            }
        }
    }
}
