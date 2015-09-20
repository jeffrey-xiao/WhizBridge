//
//  Job.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import Foundation

class Job {
    var job_id: Int?
    var job_name: String?
    var buyer_id: Int?
    var created_at: String?
 
    var job_description: String?
    var job_price: Double?
    var job_latitude: Double?
    var job_longitude: Double?
    var job_address: String?
    var job_hash: String?
    var job_completed: Int?
    
    init(json: NSDictionary) {
        self.job_id = ((json["job_id"] as? String )!.toInt())!
        self.job_name = json["job_name"] as? String
        self.buyer_id = ((json["buyer_id"] as? String )!.toInt())!
        self.job_description = json["job_description"] as? String
        self.job_address = json["job_address"] as? String
//        if let a = json["job_latitude"] ?? "0.0"  {
//            self.job_latitude = (( a  as? String )!.toDouble())
//        }
//        if let b = json["job_longitude"]  ?? "0.0"  {
//            self.job_longitude = (( b  as? String )!.toDouble())
//        }
        self.job_longitude = ((json["job_longitude"] as? String )!.toDouble())!
        self.job_latitude = ((json["job_latitude"] as? String )!.toDouble())!
        self.job_price = ((json["job_price"] as? String )!.toDouble())!
        self.created_at = json["created_at"] as? String
        self.job_hash = json["job_hash"] as? String
     
        
        
        self.job_completed = ((json["job_completed"] as? String ?? "0" )!.toInt())!
        
    }
    
    
}

extension String {
    func toDouble() -> Double? {
        return NSNumberFormatter().numberFromString(self)?.doubleValue
    }
}