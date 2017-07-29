Option Explicit

Const prefix_ = "se2016_"

Main()
MsgBox "Š®—¹"

Sub Main()
	Dim fso_
	Dim scriptFolderPath_
	Dim ddlFolder_
	Dim ddlFile_
	Dim ddlText_
	Dim input_
	Dim output_
	Dim bin_
	
	Set fso_ = CreateObject("Scripting.FileSystemObject")
	
	scriptFolderPath_ = fso_.GetFile(WScript.ScriptFullName).ParentFolder.Path
	Set ddlFolder_ = fso_.GetFolder(scriptFolderPath_ & "/ddl")
	
	Set output_ = CreateObject("ADODB.Stream")
	output_.Type = 2
	output_.Charset = "UTF-8"
	output_.Open
	
	
	For Each ddlFile_ In ddlFolder_.Files
		Set input_ = CreateObject("ADODB.Stream")
		input_.Type = 2
		input_.Charset = "UTF-8"
		input_.Open
		input_.LoadFromFile ddlFile_.Path
		ddlText_ = input_.ReadText(-1)
		ddlText_ = Replace(ddlText_, "{%prefix}", prefix_) & vbNewLine
		output_.WriteText ddlText_, 1
	Next
	
	If fso_.FileExists(scriptFolderPath_ & "/create_all_table.sql") Then
		fso_.DeleteFile(scriptFolderPath_ & "/create_all_table.sql")
	End If
	output_.Position = 0
	output_.Type = 1
	output_.Position = 3
	bin_ = output_.Read
	
	Set output_ = CreateObject("ADODB.Stream")
	output_.Type = 1
	output_.Open
	output_.Write(bin_)
	
	output_.SaveToFile scriptFolderPath_ & "/create_all_table.sql"
End Sub

