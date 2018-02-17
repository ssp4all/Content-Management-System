 <?php
$path = URL::to('json/CourseConfig.json'); //path courseConfig json file in storage folder
$json = json_decode(file_get_contents($path), true);
 ?>   
    
    <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <select name="year" class="form-control" id="year">
                        <option value="-1" disabled selected>Select Year</option>
                        <option selected>{{$date = date('Y')}}</option>
                        @for($i=$date-1;$i>=2010;$i--)
                            <option>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <select name="course" class="form-control" id="course">
                        <option value="-1">Select Course</option>   
                        @foreach($json['course'] as $course)
                            <option value="{{$course['courseIndex']}}">{{$course['courseName']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <select name="branch" class="form-control" id="branch">
                        <option value="-1" disabled selected>Select Branch</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <select name="sem" class="form-control" id="sem">
                        <option value="-1" disabled selected>Select Semester</option>
                    </select>
                </div>
            </div>
             
            {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
        {{ Form::close() }}

    </div>
    
<script type="text/javascript">
    $(document).ready(function(){
        var e;
        $(document).on('change','#course', function(){
            var course_id = $(this).val();
            e = course_id;

            var div = $('#branch').parent();
            var op = "";
            $.ajax({
                type:'get',
                url:'{!!URL::to('staff/exam-branch')!!}',
                data:{'id': course_id},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    console.log(data.length);
                    op+='<option value="-1" disabled selected>Select Branch</option>';
                    for(var i = 0;i<data.length;i++)
                    {
                        op+='<option value="'+data[i].branchindex+'">'+data[i].name+'</option>';
                    }

                    div.find('#branch').html("");
                    div.find('#branch').append(op);

                },
                error:function(){

                }
            });
            

            var d = $('#sem').parent();
            var o = "";

            $.ajax({
                type:'get',
                url:'{!!URL::to('staff/exam-sem')!!}',
                data:{'id': course_id},
                success:function(semData){
                    console.log('success');
                    console.log(semData);
                    console.log(semData.length);
                    o+='<option value="-1" disabled selected>Select Semester</option>';
                    for(var i = 1;i<=semData.semesters;i++)
                    {
                        o+='<option value="'+i+'">'+i+'</option>';
                    }

                    d.find('#sem').html("");
                    d.find('#sem').append(o);

                },
                error:function(){

                }
            });
        
        });

        

    });
</script>

