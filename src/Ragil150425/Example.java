/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil150425;

/**
 * 
 * @author Muhamad Soleh ,Polimorfiss
 */
public class Example {
    public static void main(String[] args){
        Person ref;
        Student student = new Student();
        Employee employee = new Employee();
        
        student.setName("Andi");
        employee.setName("Deri");
        ref = student;
        //System.out.println("Nama    :"+ref.getName());
        ref = employee;
        //System.out.println("Nama    :"+ref.getName());
        printInformation(student);
        printInformation(employee);
    }
    
    public static void printInformation(Person p){
        System.out.println("Nama    :"+p.getName());
        System.out.println("Alamat  :"+p.getAddress());
    }
}
