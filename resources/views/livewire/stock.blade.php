<div>
<div class="antialiased sans-serif">
	<div class="container mx-auto py-6 px-4">
	
		<div class="overflow-x-auto bg-white rounded-lg shadow relative">
			<table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
				<thead>
					<tr class="text-left">
                  <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                     Name
                  </th>
						@foreach($attributes as $attribute)
							<th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs">
                     @if(!empty($attribute->performance_month) && $attribute->performance_month < 12)
                           M {{ $attribute->performance_month }} %

                        @elseif($attribute->name == "changePercent")
                           Chg %
                        @elseif($attribute->name == "high52Wk")
                           52 Week High
                        @elseif($attribute->performance_month >= 12)
                              {{$attribute->performance_month / 12}} Y %
                        @else
                           {{$attribute->name}}
                     @endif
                     </th>
						@endforeach
					</tr>
				</thead>
				<tbody>
            @foreach($stocks as $stock)
						<tr>
							<td class="border-dashed border-t border-gray-200 userId">
								<span class="text-gray-700 px-6 py-3 flex items-center" style="font-size: 0.80em !important;">{{ $stock->ticker }}</span>
							</td>	
                     @foreach($stock->values as $value)
                     <td class="border-dashed border-t border-gray-200 userId">
								<span class="text-gray-700 px-6 py-3 flex items-center " style="font-size: 0.80em !important;">
                        @if($value->attribute->name == 'volume')

                           {{ getFormattedNum($value->value)  }}

                           @elseif($value->attribute->name == 'macd')

                              {{number_format($value->value, 2, ".", "")}}

                           @elseif($value->attribute->name == 'rsi')

                              {{number_format($value->value, 2, ".", "")}}

                           @elseif($value->attribute->name == 'changePercent')

                           <span class="@if($value->value > 0) text-green-500 @else text-red-500 @endif">{{number_format($value->value, 2, ".", "")}}</span>

                           @elseif($value->attribute->name == 'high52Wk')

                              {{number_format($value->value, 2, ".", "")}}

                           @elseif(!empty($value->attribute->performance_month))
                           <span class="@if($value->value > 0) text-green-500 @else text-red-500 @endif">
                              {{number_format($value->value, 2, ".", "")}}
                           </span>
                           @else
                              {{ $value->value }}
                           @endif
                        </span>
							</td>	
                     @endforeach
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	</div>
   {{$stocks->links()}}
</div>
