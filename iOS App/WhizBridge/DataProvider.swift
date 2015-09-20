//
//  DataProvider.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import Foundation
import CoreLocation
import UIKit

class DataProvider {
    
    var networkTask = NSURLSessionDataTask()
    var session: NSURLSession {
        return NSURLSession.sharedSession()
    }
    var auth_hash: String!
    let baseURL = "http://whizbridge.com/api-v1/"
    
    //initialize the user id and auth hash if they are available (user is logged in)
    init(){
        let isUserLoggedIn = NSUserDefaults.standardUserDefaults().boolForKey("isUserLoggedIn")
        if(isUserLoggedIn){
            auth_hash = NSUserDefaults.standardUserDefaults().valueForKey("auth_hash") as? String
        }
    }
    
    //reload the userdata for accessing the api be reseting the dataprovider's user id and auth hash to those in user defaults
    func reloadUserData(){
        let isUserLoggedIn = NSUserDefaults.standardUserDefaults().boolForKey("isUserLoggedIn")
        if(isUserLoggedIn){
            auth_hash = NSUserDefaults.standardUserDefaults().valueForKey("auth_hash") as? String
        }
    }
    
    //check for network connectivity (is wifi/data turned on or off)
    func hasConnectivity() -> Bool {
        let reachability: Reachability = Reachability.reachabilityForInternetConnection()
        let networkStatus: Int = reachability.currentReachabilityStatus.hashValue
        return networkStatus != 0
    }
    
    //login the user, get auth_hash for username/email or password
    func login(user: String, password: String, completion: ((Int) -> Void)) -> () {
        //set up request
        let functionURL = NSURL(string: baseURL + "attemptLogin")
        let request = NSMutableURLRequest(URL: functionURL!)
        request.HTTPMethod = "POST"
        
        let postString = "user=\(user)&password=\(password)"
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding)
        session.configuration.timeoutIntervalForResource = 6.0
        session.configuration.timeoutIntervalForRequest = 3.0
        
        //sanity check for internet availability
        if self.hasConnectivity() == false {
            completion(-31)
            return
        } else { //make the network call
            UIApplication.sharedApplication().networkActivityIndicatorVisible = true
            networkTask = session.dataTaskWithRequest(request) {data, response, error in
                UIApplication.sharedApplication().networkActivityIndicatorVisible = false
                
                //output error if applicable
                if error != nil {
                    println("error=\(error)")
                    completion(0)
                    return
                }
                
                //parse json response
                var jsonError: NSError?
                if let jsonResponse = NSJSONSerialization.JSONObjectWithData(data, options: .MutableContainers, error: &jsonError) as? NSDictionary {
                    if jsonError != nil {
                        println("error=\(jsonError)")
                        completion(0)
                        return
                    }
                    var status = jsonResponse["status"] as! Int
                    if status == 1 {
                        self.auth_hash = jsonResponse["auth_hash"] as? String
                        NSUserDefaults.standardUserDefaults().setValue((jsonResponse["auth_hash"] as? String), forKey: "auth_hash")
                        NSUserDefaults.standardUserDefaults().synchronize()
                    }
                    dispatch_async(dispatch_get_main_queue()) {
                        completion(status)
                    }
                }
            }
        }
        networkTask.resume()
    }
    
    func processPayment(typeString: String, completion: ((String) -> Void)) -> () {
        //set up request
        let functionURL = NSURL(string: "http://whizbridge.com/braintree-test.php")
        let request = NSMutableURLRequest(URL: functionURL!)
        request.HTTPMethod = "POST"
        
        let postString = "payment_method_nonce=\(typeString)"
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding)
        session.configuration.timeoutIntervalForResource = 6.0
        session.configuration.timeoutIntervalForRequest = 3.0
        
        //sanity check for internet availability
        if self.hasConnectivity() == false {
            completion("fuck")
            return
        } else { //make the network call
            UIApplication.sharedApplication().networkActivityIndicatorVisible = true
            networkTask = session.dataTaskWithRequest(request) {data, response, error in
                UIApplication.sharedApplication().networkActivityIndicatorVisible = false
                
                //output error if applicable
                if error != nil {
                    println("error=\(error)")
                    completion("fuck")
                    return
                }
                
                //do shit
                dispatch_async(dispatch_get_main_queue()) {
                    completion("ayyyy")
                }
            }
        }
        networkTask.resume()

    }
    func fetchJobs(completion: (([Job]) -> Void)) -> () {
        //set up request
        let functionURL = NSURL(string: baseURL + "fetchJobs?auth_hash=\(auth_hash)")
        let request = NSMutableURLRequest(URL: functionURL!)
        request.HTTPMethod = "GET"
        
       println(functionURL)
        
        //sanity check for internet availability
        if self.hasConnectivity() == false {
            //completion(Job())
            return
        } else { //make the network call
            UIApplication.sharedApplication().networkActivityIndicatorVisible = true
            networkTask = session.dataTaskWithRequest(request) {data, response, error in
                UIApplication.sharedApplication().networkActivityIndicatorVisible = false
                
                //output error if applicable
                if error != nil {
                    println("error=\(error)")
                    //completion("fuck")
                    return
                }
                
                var jsonError: NSError?
                if let jsonResponse = NSJSONSerialization.JSONObjectWithData(data, options: .MutableContainers, error: &jsonError) as? [NSDictionary] {
                    if jsonError != nil {
                        println("error=\(jsonError)")
                        //completion(0)
                        return
                    }
                    var jobsArray = [Job]()
                    for job in jsonResponse {
                        jobsArray.append(Job(json: job))
                    }
                    
                    dispatch_async(dispatch_get_main_queue()) {
                        completion(jobsArray)
                    }
                }
            }
        }
        networkTask.resume()
        
    }
    
    func fetchIndividualJob(job_id: Int, completion: ((Job) -> Void)) -> () {
        //set up request
        let functionURL = NSURL(string: baseURL + "fetchIndividualJob?job_id=\(job_id)")
        let request = NSMutableURLRequest(URL: functionURL!)
        request.HTTPMethod = "GET"
        
        
        
        //sanity check for internet availability
        if self.hasConnectivity() == false {
            //completion(Job())
            return
        } else { //make the network call
            UIApplication.sharedApplication().networkActivityIndicatorVisible = true
            networkTask = session.dataTaskWithRequest(request) {data, response, error in
                UIApplication.sharedApplication().networkActivityIndicatorVisible = false
                
                //output error if applicable
                if error != nil {
                    println("error=\(error)")
                    //completion("fuck")
                    return
                }
                
                var jsonError: NSError?
                if let jsonResponse = NSJSONSerialization.JSONObjectWithData(data, options: .MutableContainers, error: &jsonError) as? NSDictionary {
                    if jsonError != nil {
                        println("error=\(jsonError)")
                        //completion(0)
                        return
                    }
                 
                    
                    dispatch_async(dispatch_get_main_queue()) {
                        completion(Job(json: jsonResponse))
                    }
                }
            }
        }
        networkTask.resume()
        
    }
    
    func postJob(name: String, description: String, address: String, price: String, email: String, cardNumber: String, expiry: String, cvv: String, postal: String, cardHolder: String, lat: Double, long: Double, completion: ((Int) -> Void))->() {
        //set up request
        println("a")
        let functionURL = NSURL(string: baseURL + "postJob")
        let request = NSMutableURLRequest(URL: functionURL!)
        request.HTTPMethod = "POST"
        
        let postString = "job_name=\(name)&job_description=\(description)&job_address=\(address)&job_price=\(price)&email=\(email)&card_number=\(cardNumber)&expiry_date=\(expiry)&cvv=\(cvv)&postal_code=\(postal)&card_holder_name=\(cardHolder)&job_latitude=\(lat)&job_longitude=\(long)"
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding)
        session.configuration.timeoutIntervalForResource = 6.0
        session.configuration.timeoutIntervalForRequest = 3.0
        println("b")
        //sanity check for internet availability
        if self.hasConnectivity() == false {
            completion(-31)
            return
        } else { //make the network call
            println("c")
            UIApplication.sharedApplication().networkActivityIndicatorVisible = true
            networkTask = session.dataTaskWithRequest(request) {data, response, error in
                UIApplication.sharedApplication().networkActivityIndicatorVisible = false
                println("d")
                //output error if applicable
                if error != nil {
                    println("error=\(error)")
                    completion(0)
                    return
                }
                println("e")
                println("\(data)")
                //parse json response
                var jsonError: NSError?
                if let jsonResponse = NSJSONSerialization.JSONObjectWithData(data, options: .MutableContainers, error: &jsonError) as? NSDictionary {
                    println("e.3")
                    if jsonError != nil {
                        println("error=\(jsonError)")
                        completion(0)
                        return
                    }
                    println("e.5")
                    var status = jsonResponse["status"] as! Int
                    println("f")
                    dispatch_async(dispatch_get_main_queue()) {
                        completion(status)
                    }
                }
            }
        }
        networkTask.resume()
        
    }
    
}
