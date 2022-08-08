<div>
   <h1 class="text-center uppercase py-2">Overbought Stocks </h1>
   <table class="w-full whitespace-no-wrap mb-5">
      <thead>
      <tr class="text-xs font-semibold tracking-wide text-left text-blue-500 uppercase border-b dark:border-blue-700 bg-blue-50 dark:text-blue-400 dark:bg-blue-800">
         <th class="px-2 py-1">
            Name
         </th>
         @foreach($attributes as $attribute)
         <th class="px-2 py-1">
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
      <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
      @foreach($stocks as $stock)
         <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-1">
               <div class="flex items-center text-sm">
                  <div>
                     <p class="font-semibold"></p>
                     <p class="text-xs text-gray-600 dark:text-gray-400">
                        {{ $stock->ticker }}
                     </p>
                  </div>
               </div>
            </td>
            @foreach($stock->values as $value)
            <td class="px-2 py-1 text-sm">
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
            </td>
            @endforeach
         </tr>
      @endforeach
      </tbody>
   </table>
   {{$stocks->links()}}
</div>
